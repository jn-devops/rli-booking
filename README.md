## About RLI Booking

RLI Booking is a stand-alone web application for interactive and API-based sales reservation of real estate properties of Raemulan Lands Inc.

Basically, it should 
- accept Product SKU,
  - Transaction Reference, Email Address as optional inputs for web access OR
  - Transaction Reference, Callback URL as required inputs for API access
- then web popup to 
  - choose a specific property,
  - choose a financing scheme,
  - perform eKYC
- then generate an invoice (and/or a quote) with payment QR Code for the processing fee
- and then
  - present a download page for invoice and quote for web access OR
  - send order details by performing a webhook on the API client host for API access
## Models
- Product
  - SKU
  - Name
  - Processing Fee
  - Product Attributes
- Property
  - Code
  - SKU
  - Property Attributes
- Buyer
  - Name
  - Address
  - Birthdate
  - Mobile
  - ID Type
  - ID Number
  - ID Image URL
  - Selfie Image URL
  - ID Mark URL
- Seller
  - Code
  - Name
  - Email
  - Mobile
- MonthsToPayDownPayment
  - Code
  - Name
- PercentDownPayment
  - Code
  - Name
- Order
  - Reference
  - Product
  - Property
  - DownPaymentTerms
    - MonthsToPayDownPayment
    - PercentDownPayment
  - Buyer
  - Seller
  - Campaign (KwYC Check Campaign)
  - Status
## Enumerations
- MonthsToPayDownPaymentCode
- PercentDownPaymentCode
## Seeds
- Product
- MonthsToPayDownPayment
- PercentDownPayment
## Packages
- maatwebsite/excel
- spatie/laravel-webhook-server
- spatie/laravel-model-states
- spatie/laravel-schemaless-attributes
- pusher/pusher-php-server
- bacon/bacon-qr-code (default with Laravel)
- lorisleiva/laravel-actions
- frittenkeez/laravel-vouchers
## Actions
- SetOrderSeller
- SetOrderProduct
- SetOrderProcessingFee
- GetAvailablePropertiesFromActiveProduct
- DisplayKeyMapFromAvailableProperties
- SetOrderProperty
- GetAvailableDownPaymentTermsFromProduct
- DisplayFinancialCalculator
- SetOrderDownPaymentTerms
- GetCampaignFromProduct
- SetOrderCampaign
- DisplayCampaignPrompt
- GenerateQuote (in case no KYC)
- GenerateInvoice
- GetOrderStatus
- SendOrder
- xxx
- NewOrder
## Routes
- GET /?sku=<SKU>&reference=<REFERENCE>&email=<EMAIL>
- GET status/?reference=<REFERENCE>
- GET quote/?reference=<REFERENCE>
- GET invoice/?reference=<REFERENCE>
- POST api/new `{"sku": "<PRODUCT SKU>", "reference": "<REFERENCE CODE>", callback:"<CALLBACK URL>"}`
- GET api/status `{"reference": "<REFERENCE CODE>"}`
### Developers
- **[Lester B. Hurtado](mailto:devops@joy-nostalg.com)**
- **[Charles Kenneth C. Hernandez](mailto:cchernandez@joy-nostalg.com)**
- **[Chona L. Andrade](mailto:clandrade@joy-nostalg.com)**
- **[Angelica Anais C. Santos](mailto:aacsantos@joy-nostalg.com)**
- **[Reydalin R. Barroso](mailto:rrbarroso@joy-nostalg.com)**
- **[Kevin Dickson C. Eusebio](mailto:kceusebio@joy-nostalg.com)**

## Security Vulnerabilities

If you discover a security vulnerability within RLI Booking, please send an e-mail to Lester Hurtado via [devops@joy-nostalg.com](mailto:devops@joy-nostalg.com). All security vulnerabilities will be promptly addressed.

## License

RLI Booking is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
