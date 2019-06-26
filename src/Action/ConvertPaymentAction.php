<?php

namespace Kiboko\SyliusPayzenBundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\RuntimeException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Sylius\Component\Core\Model\PaymentInterface;
use Payum\Core\Request\Convert;
use Payum\Core\Request\GetCurrency;

/**
 * Class ConvertPaymentAction
 * @package Kiboko\SyliusPayzenBundle\Action
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ConvertPaymentAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritDoc}
     *
     * @param Convert $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        $order = $payment->getOrder();
        $gatewayConfig = $payment->getMethod()->getGatewayConfig()->getConfig();

        $model = ArrayObject::ensureArrayObject($payment->getDetails());

        if (false == $model['vads_amount']) {
            $this->gateway->execute($currency = new GetCurrency($payment->getCurrencyCode()));
            if (2 < $currency->exp) {
                throw new RuntimeException('Unexpected currency exp.');
            }
            $divisor = pow(10, 2 - $currency->exp);

            $model['vads_currency'] = (string)$currency->numeric;
            $model['vads_amount'] = (string)abs($order->getTotal() / $divisor);
        }

        if (false == $model['vads_order_id']) {
            $model['vads_order_id'] = $order->getNumber();
        }
        if (false == $model['vads_cust_id']) {
            $model['vads_cust_id'] = $order->getCustomer()->getId();
        }
        if (false == $model['vads_cust_email']) {
            $model['vads_cust_email'] = $order->getCustomer()->getEmail();
        }
        
        if (isset($gatewayConfig['n_times']) && $gatewayConfig['n_times']) {
            $count = (int) $gatewayConfig['count'];
            $period = (int) $gatewayConfig['period'];
            if ($count > 1 && $period > 0) {
                $first = round($model['vads_amount'] / $count);
                $model['vads_payment_config'] = sprintf('MULTI:first=%d;count=%d;period=%d', $first, $count, $period);
            }
        }

        $request->setResult((array)$model);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof Convert
            && $request->getSource() instanceof PaymentInterface
            && $request->getTo() == 'array';
    }
}
