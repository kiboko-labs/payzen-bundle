<?php

namespace Kiboko\SyliusPayzenBundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\RuntimeException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Convert;
use Payum\Core\Request\GetCurrency;
use Sylius\Component\Core\Model\PaymentInterface;
use Webmozart\Assert\Assert;

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
        Assert::notNull($order);
        $customer = $order->getCustomer();
        Assert::notNull($customer);
        /**
         * @todo create a getConfig() method on the \Ekyna\Component\Payum\Payzen\Api\Api
         *       to get the config from the gateway, instead of getting it from the payment method gateway config.
         */
        $paymentMethod = $payment->getMethod();
        Assert::notNull($paymentMethod);
        $gatewayConfig = $paymentMethod->getGatewayConfig();
        Assert::notNull($gatewayConfig);
        $config = $gatewayConfig->getConfig();

        $model = ArrayObject::ensureArrayObject($payment->getDetails());

        if (false === $model['vads_amount']) {
            $this->gateway->execute($currency = new GetCurrency($payment->getCurrencyCode()));
            if (2 < $currency->exp) {
                throw new RuntimeException('Unexpected currency exp.');
            }
            $divisor = 10 ** (2 - $currency->exp);

            $model['vads_currency'] = (string)$currency->numeric;
            $model['vads_amount'] = (string)abs($order->getTotal() / $divisor);
        }

        if (false === $model['vads_order_id']) {
            $number = $order->getNumber();
            Assert::notNull($number);
            $model['vads_order_id'] = $number;
        }

        if (false == $model['vads_cust_id']) {
            $model['vads_cust_id'] = $customer->getId();
        }
        if (false == $model['vads_cust_email']) {
            $model['vads_cust_email'] = $customer->getEmail();
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
            && $request->getTo() === 'array';
    }
}
