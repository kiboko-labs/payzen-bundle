VERSION=0.1.0
DESTINATION=build/
.PHONY: build
build:
	composer archive \
		--format=tar \
		--dir=$(DESTINATION) \
		--file $(shell jq -r '.name | split("/")[1]' composer.json)-$(VERSION)
