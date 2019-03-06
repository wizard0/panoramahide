#!/usr/bin/env make

.PHONY : help
.DEFAULT_GOAL := help
SRC ?= ./app/*
TESTS ?= ./tests/*

help: ## Показать эту подсказку
	@echo "Сборка. Портал panor.ru"
	@echo "© ООО «Панорама» 2019, Все права защищены."
	@echo "Автор: Денис Парыгин (dyp2000@mail.ru)\n"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[33m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo "  Вы можете изменить следующие параметры:\n\
		SRC - Файл для статического анализа кода\n\
		Примеры:\n\
		   make SRC=./app/Http/Controllers analyze\n\
		   make SRC=./app/Http/Controllers/Controller.php analyze\n"

clear: ## Очиститить проект
	composer clearcache
	rm -rf ./vendor
	rm -rf ./node_modules
	rm -rf ./test-coverage
	rm -f ./composer.lock
	rm -f ./package-lock.json

build: clear ## Сборать проект
	composer install
	composer dumpautoload
	npm install
	npm run dev

seed: ## Заполнить БД тестовыми данными
	artisan migrate:fresh
	artisan db:seed --class=TestSeeder

admin: ## Создать пользователя admin (user: admin; pass: admin)
	artisan admin:create

test: seed ## Тестировать проект
	./vendor/phpunit/phpunit/phpunit --testdox --coverage-html ./test-coverage

paratest: seed ## Тестировать проект (тесты запускаются параллельно)
	./vendor/brianium/paratest/bin/paratest -p8 --coverage-html=./test-coverage

psr: ## Анализ кода по PSR. По умолчанию SRC=./app/*
	@echo "\033[33m\n... Анализ исхоных текстов ...\033[0m\n"
	./vendor/squizlabs/php_codesniffer/bin/phpcs ${SRC} -n --report-full --colors --standard=PSR1 --standard=PSR2 --standard=PSR12 || true
	@echo "\033[33m\n... Анализ тестов ...\033[0m\n"
	./vendor/squizlabs/php_codesniffer/bin/phpcs ${TESTS} -n --report-full --colors --standard=PSR1 --standard=PSR2 --standard=PSR12 || true

analyse: ## Статический анализ кода
	./artisan code:analyse || true

---------------: ## ---------------
