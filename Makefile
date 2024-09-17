.PHONY: qa
qa: phpstan rector-dry cs tests changelog

# See: https://github.com/crossnox/m2r2
.PHONY: changelog
changelog:
	python3 -m venv .Build/changelog
	.Build/changelog/bin/pip install setuptools m2r2
	.Build/changelog/bin/m2r2 CHANGELOG.md && \
	echo ".. _changelog:" | cat - CHANGELOG.rst > /tmp/CHANGELOG.rst && \
	mv /tmp/CHANGELOG.rst Documentation/Changelog/Index.rst && \
	rm CHANGELOG.rst

.PHONY: cs
cs:
	.Build/bin/ecs check --fix

.PHONE: docs
docs:
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation

.PHONY: phpstan
phpstan:
	.Build/bin/phpstan analyse

.PHONY: rector
rector:
	.Build/bin/rector

.PHONY: rector-dry
rector-dry:
	.Build/bin/rector --dry-run

.PHONY: tests
tests:
	.Build/bin/phpunit --configuration=Tests/phpunit.xml.dist

.PHONY: zip
zip:
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'
