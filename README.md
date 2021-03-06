# Teste de seleção para desenvolvedor PHP

Esse teste é dividido em 6 exercícios.

Serão analisados:

 - Estrutura, código organizado e limpo
 - Conceitos SOLID
 - Uso e **conhecimento** dos recursos do **Laravel**

*A ideia não é fazer o mais rápido possivel apenas para executar com sucesso os testes automatizados. Se necessário poderá ser utilizado um tempo maior do que foi passado.*

# Instruções

O projeto esta foi feito em Laravel e banco de dados MySql.

Para iniciar é necessário clonar o projeto:

```
git clone git@bitbucket.org:cplug/provaphp.git

```
Instalar os pacotes e executar os migrates

```php
composer install
cp .env.example .env 
php artisan migrate
```

Podem ser adicionados outros métodos nos arquivos de teste porém os que existem **não devem** ser modificados. E o objetivo final é executar todos os testes existentes com sucesso.

Ao finalizar encaminhar via email ou whatsapp o projeto zipado (sem a pasta vendor).

# Exercícios

## 01 - Clientes

Para esse exercicío será utilizado o arquivo [CustomerController](https://bitbucket.org/cplug/provaphp/src/master/app/Http/Controllers/CustomerController.php)

 - Refatorar o método *CustomerController@store* 
 - Implementar o método *CustomerController@update*

Fique livre para fazer **qualquer alteração** no projeto (exceto nos testes unitários):

Ao final do exercicio o teste abaixo deve executar com sucesso:

```php
php artisan test --filter=CustomerTest
```

## 02 - Cálculo de parcelas

A rota /api/payment/calculate/<valor>/<parcelas> recebe um valor e a quantidade de parcelas de um pagamento. E retorna as parcelas com seus respectivos valores. Porém quando tentamos parcelar 100 reais em 3x ocorre um bug e o somatório das parcelas é 99,99 reais.

 - Corrigir o bug de cálculo do método PaymentController@calculate do arquivo [PaymentController](https://bitbucket.org/cplug/provaphp/src/master/app/Http/Controllers/PaymentController.php). 
 
 Ao final do exercicio o teste abaixo deve executar com sucesso:

```php
php artisan test --filter=PaymentTest
```

## 03 - Consumo de API

Implementar uma API que receba um tipo de cryptmoeda, a data de compra e a data de venda e quantidade. E que retorne o valor pago, o valor vendido e o lucro. 

Exemplo de entrada no endpoint /api/crypto/PSGFT :

```json
{
    "quantidade": 250,
    "dataCompra": "2021-02-01",
    "dataVenda": "2021-04-18"
}
```

Exemplo de saída:

```json
{
    "valor_da_compra": 10513.88,
    "valor_da_venda": 46656.85,
    "lucro": 36142.97,
    "lucro_percentual": 343.76,
    "intervalo_em_dias": 76
}
```
Essa chamada esta descrita no arquivo [ApiTest](https://bitbucket.org/cplug/provaphp/src/master/tests/Feature/ApiTest.php)

Para o calculo do valor utilizar o preço médio do dia segundo essa API Pública [https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary](https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary)

Ao final do exercicio o teste abaixo deve executar com sucesso:

```php
php artisan test --filter=ApiTest
```

## 04 - Verifica se um intervalo está disponivel

Dado dois intervalos de horarios:

* selected - é o intervalo de horario que se deseja utilizar
* blocked - é o intervalo de horarios que já esta ocupado e não é possível utilizar

```php
//escolhido das 07h as 08h
$selected = ['start' => '07:00', 'end' => '08:00'];

//ja esta reservado das 09h as 10h
$blocked = ['start' => '09:00', 'end' => '10:00'];

//nesse exemplo podemos fazer a reserva pois o intervalo das 7 as 8h está livre
```
Para a execução desse exercicio só precisa do arquivo [SchedulerTest](https://bitbucket.org/cplug/provaphp/src/master/tests/Feature/SchedulerTest.php)

Implementar a lógica do método **SchedulerTest@isBusy** para que o teste abaixo execute com sucesso:

```php
php artisan test --filter=SchedulerTest
```
Exemplo de saída de teste executado corretamente:

```
   PASS  Tests\Feature\SchedulerTest
  ✓ selected equal blocked
  ✓ selected before
  ✓ selected after
  ✓ selected between blocked
  ✓ selected initial between blocked
  ✓ selected final between blocked
  ✓ selected before blocked
  ✓ selected after blocked
  ✓ blocked between selected

  Tests:  9 passed
  Time:   0.57s
```

## 05 - Modelagem de Produtos com Atributos

Criar os arquivos de migrates com as tabelas necessárias para armazenar produtos que possuem atributos (ex: cor, tamanho, tipo, material, etc.). Os produtos podem ter mais de um atributo.

Alguns exemplos:

* Camiseta da seleção brasileira
    * Tamanho: P, M, G e GG

* Chuteira da Nike
    * Tamanho: 36, 38, 40, 42
    * Cores: Azul, Vermelho, Verde, Rosa

Deverá ser possível armazenar o **preço** e a **quantidade** em estoque de cada variação do item.

Exemplos:

* Tinta de parede azul custa R$15,00 e tinta de parede branca custa R$10,00
* Chuteira da Nike 36 tem 5 em estoque. Já o tamanho Vermelho tem 3 unidades em estoque

## 06 - Front-end

Utlizando qualquer framework (JQuery, React, Vue.js, JS puro) crie um formulario com os campos data de compra, data de venda, codigo da moeda e quantidade.

Ao submeter o formulário deverá exibir as informações retornadas da API gerada no Exercício 03.

Validar os campos dos formulários:

* Data de venda tem que ser maior que de compra
* moedas válidas: BCH, BTC, CAIFT, CHZ, ETH, GALFT, IMOB01, JUVFT, LINK, LTC, OGFT, PAXG, PSGFT, USDC, WBX, XRP
