#!/usr/bin/env make

.PHONY : help
.DEFAULT_GOAL := help

help: ## Показать эту подсказку
	@echo "Сборка. Портал panor.ru"
	@echo "© ООО «Панорама» 2019, Все права защищены."
	@echo "Автор: Денис Парыгин (dyp2000@mail.ru)\n"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[33m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

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
	phpunit --coverage-html ./test-coverage
