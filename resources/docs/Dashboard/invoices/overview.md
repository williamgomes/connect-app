# Invoices

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)

### Model

Parameter | Type | Description
--------- | ---- | -----------
uuid | string | The UUID of the invoice
invoice_number | integer | The number of the invoice per legal entity
legal_entity_id | integer | The ID of the legal entity of the invoice
tms_instance_id | integer | The ID of the tms instance of the invoice
client_id | integer | The ID of the client of the invoice
currency_id | integer | The ID of the currency of the invoice
credit_note_id | integer | The ID of the credit note of the invoice if exists
type | string | The type of the invoice. Can be `invoice` or `credit note` 
status | string | The status of the invoice. Can be `unpaid`, `paid` or `credited` 
date | date | The issue date of the invoice 
due_date | date | The due date (deadline) of the invoice 
bank_account | string | The bank account of the invoice 
reference | string | The reference of the invoice 
net_amount | float | The total net amount of the invoice
vat_amount | float | The total vat amount of the invoice
gross_amount | float | The total gross amount of the invoice
created_at | datetime | The date of the invoice creation 
updated_at | datetime | The date of the invoice last update

<a name="index"></a>
## Index

This endpoint indexes all invoices in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/invoices`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
type | string | No | Search for a specific type. We only return exact match.
status | string | No | Search for a specific status. We only return exact match.
client_name | string | No | Search for a specific client by name.
amount_from | string | No | Search for invoices with gross amount not less than given value.
amount_to | string | No | Search for invoices with gross amount not more than given value.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/invoices?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "amount_from": "1000",
        "amount_to": "1500"
    }'
```

### Example Response

```json
{
  "data": [
    {
      "id": 12,
      "uuid": "33d82acd-04bb-48df-8834-f66c5942fb4f",
      "invoice_number": 12,
      "type": "invoice",
      "status": "unpaid",
      "date": "2021-08-31",
      "bank_account": "30445553030002",
      "reference": "31023012032",
      "net_amount": 1250,
      "vat_amount": 150,
      "gross_amount": 1400,
      "credit_note_id": null,
      "currency": {
        "id": 2,
        "name": "Armenian Dram",
        "code": "AMD",
        "prepend": null,
        "append": " AMD",
        "thousand_separator": ".",
        "decimal_separator": ","
      },
      "client": {
        "id": 1,
        "uuid": "1b4fb590-98ae-4a7e-a860-34d08e84b154",
        "name": "GURAM AS",
        "type": "business",
        "country": {
          "id": 1,
          "name": "Afghanistan",
          "iso_code": "AF",
          "phone_code": "93"
        },
        "id_number": "ID392922939",
        "vat_identifier": "1341242"
      },
      "legal_entity": {
        "id": 1,
        "name": "Legal Entity Example",
        "organization_number": "23532532523",
        "contact_person": "John Doe",
        "phone": "+37870001780",
        "email": "johnDoe@mail.com",
        "address_line": "Address 38, 32",
        "address_postal_code": "324212",
        "address_city": "Yerevan",
        "country": {
          "id": 8,
          "name": "Armenia",
          "iso_code": "AM",
          "phone_code": "374"
        },
        "currency": {
          "id": 2,
          "name": "Armenian Dram",
          "code": "AMD",
          "prepend": null,
          "append": " AMD",
          "thousand_separator": ".",
          "decimal_separator": ","
        }
      },
      "tms_instance": {
        "id": 1,
        "name": "ACNO",
        "identifier": "acno",
        "base_url": "http://connect.test",
        "bearer_token": "3491234030430042304230403",
        "legal_entity": {
          "id": 1,
          "name": "Legal Entity Example",
          "organization_number": "23532532523",
          "contact_person": "John Doe",
          "phone": "+37870001780",
          "email": "johnDoe@mail.com",
          "address_line": "Address 38, 32",
          "address_postal_code": "324212",
          "address_city": "Yerevan",
          "country": {
            "id": 8,
            "name": "Armenia",
            "iso_code": "AM",
            "phone_code": "374"
          },
          "currency": {
            "id": 2,
            "name": "Armenian Dram",
            "code": "AMD",
            "prepend": null,
            "append": " AMD",
            "thousand_separator": ".",
            "decimal_separator": ","
          }
        }
      },
      "invoice_lines": [
        {
          "id": 58,
          "vat_percentage": 20,
          "quantity": 5,
          "unit_net_amount": 50,
          "net_amount": 250,
          "vat_amount": 50,
          "gross_amount": 300,
          "description": "The description of the first line",
          "comment": "The comment of the first line"
        },
        {
          "id": 59,
          "vat_percentage": 10,
          "quantity": 10,
          "unit_net_amount": 100,
          "net_amount": 1000,
          "vat_amount": 100,
          "gross_amount": 1100,
          "description": "The description of the second line",
          "comment": "The comment of the second line"
        }
      ]
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v1/invoices?page=1",
    "last": "https://{environment}.synega.com/api/v1/invoices?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/invoices?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v1/invoices",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

<a name="create"></a>
## Create

This endpoint creates an invoice in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/invoices`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
tms_instance_id | integer | **YES** | The ID of the tms instance of the invoice
client_id | integer | **YES** | The ID of the client of the invoice
date | date | **YES** | The issue date of the invoice
due_date | date | **YES** | The due date (deadline) of the invoice
bank_account | string | No |  The bank account of the invoice
reference | string | No | The reference of the invoice
invoice_lines | array | **YES** | The array of invoice lines which the invoice is based on.
invoice_lines.vat_percentage | float | **YES** | The vat percentage of the line
invoice_lines.quantity | float | **YES** | The quantity of the units provided
invoice_lines.unit_net_amount | float | **YES** | The net amount per unit. 
invoice_lines.description | string | **YES** | The description of the line
invoice_lines.comment | string | **YES** | The comment of the line

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/invoices \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
          "client_id": 1,
          "tms_instance_id": 1,
          "date": "2021-08-31",
          "due_date": "2021-01-03",
          "invoice_lines": [
              [
                "quantity: 1,
                "vat_percentage": 20,
                "unit_net_amount": 100,
                "description": "The description of the first line",
                "comment": "The comment of the first line",
              ],
              [
                "quantity: 3,
                "vat_percentage": 10,
                "unit_net_amount": 100,
                "description": "The description of the second line",
                "comment": "The comment of the second line",
              ]
        ],
    }'
```

### Example Response

```json
{
  "data": {
    "id": 12,
    "uuid": "33d82acd-04bb-48df-8834-f66c5942fb4f",
    "invoice_number": 12,
    "type": "invoice",
    "status": "unpaid",
    "date": "2021-08-31",
    "bank_account": "30445553030002",
    "reference": "31023012032",
    "net_amount": 400,
    "vat_amount": 50,
    "gross_amount": 450,
    "credit_note_id": null,
    "currency": {
      "id": 2,
      "name": "Armenian Dram",
      "code": "AMD",
      "prepend": null,
      "append": " AMD",
      "thousand_separator": ".",
      "decimal_separator": ","
    },
    "client": {
      "id": 1,
      "uuid": "1b4fb590-98ae-4a7e-a860-34d08e84b154",
      "name": "GURAM AS",
      "type": "business",
      "country": {
        "id": 1,
        "name": "Afghanistan",
        "iso_code": "AF",
        "phone_code": "93"
      },
      "id_number": "ID392922939",
      "vat_identifier": "1341242"
    },
    "legal_entity": {
      "id": 1,
      "name": "Legal Entity Example",
      "organization_number": "23532532523",
      "contact_person": "John Doe",
      "phone": "+37870001780",
      "email": "johnDoe@mail.com",
      "address_line": "Address 38, 32",
      "address_postal_code": "324212",
      "address_city": "Yerevan",
      "country": {
        "id": 8,
        "name": "Armenia",
        "iso_code": "AM",
        "phone_code": "374"
      },
      "currency": {
        "id": 2,
        "name": "Armenian Dram",
        "code": "AMD",
        "prepend": null,
        "append": " AMD",
        "thousand_separator": ".",
        "decimal_separator": ","
      }
    },
    "tms_instance": {
      "id": 1,
      "name": "ACNO",
      "identifier": "acno",
      "base_url": "http://connect.test",
      "bearer_token": "3491234030430042304230403",
      "legal_entity": {
        "id": 1,
        "name": "Legal Entity Example",
        "organization_number": "23532532523",
        "contact_person": "John Doe",
        "phone": "+37870001780",
        "email": "johnDoe@mail.com",
        "address_line": "Address 38, 32",
        "address_postal_code": "324212",
        "address_city": "Yerevan",
        "country": {
          "id": 8,
          "name": "Armenia",
          "iso_code": "AM",
          "phone_code": "374"
        },
        "currency": {
          "id": 2,
          "name": "Armenian Dram",
          "code": "AMD",
          "prepend": null,
          "append": " AMD",
          "thousand_separator": ".",
          "decimal_separator": ","
        }
      }
    },
    "invoice_lines": [
      {
        "id": 58,
        "vat_percentage": 20,
        "quantity": 5,
        "unit_net_amount": 50,
        "net_amount": 100,
        "vat_amount": 20,
        "gross_amount": 120,
        "description": "The description of the first line",
        "comment": "The comment of the first line"
      },
      {
        "id": 59,
        "vat_percentage": 10,
        "quantity": 10,
        "unit_net_amount": 100,
        "net_amount": 300,
        "vat_amount": 30,
        "gross_amount": 330,
        "description": "The description of the second line",
        "comment": "The comment of the second line"
      }
    ]
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific invoice in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/invoices/{invoice_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
invoice_id <small>(url param)</small> | integer | **Yes** | The unique ID of the invoice.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/invoices/{invoice_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 12,
    "uuid": "33d82acd-04bb-48df-8834-f66c5942fb4f",
    "invoice_number": 12,
    "type": "invoice",
    "status": "unpaid",
    "date": "2021-08-31",
    "bank_account": "30445553030002",
    "reference": "31023012032",
    "net_amount": 1250,
    "vat_amount": 150,
    "gross_amount": 1400,
    "credit_note_id": null,
    "currency": {
      "id": 2,
      "name": "Armenian Dram",
      "code": "AMD",
      "prepend": null,
      "append": " AMD",
      "thousand_separator": ".",
      "decimal_separator": ","
    },
    "client": {
      "id": 1,
      "uuid": "1b4fb590-98ae-4a7e-a860-34d08e84b154",
      "name": "GURAM AS",
      "type": "business",
      "country": {
        "id": 1,
        "name": "Afghanistan",
        "iso_code": "AF",
        "phone_code": "93"
      },
      "id_number": "ID392922939",
      "vat_identifier": "1341242"
    },
    "legal_entity": {
      "id": 1,
      "name": "Legal Entity Example",
      "organization_number": "23532532523",
      "contact_person": "John Doe",
      "phone": "+37870001780",
      "email": "johnDoe@mail.com",
      "address_line": "Address 38, 32",
      "address_postal_code": "324212",
      "address_city": "Yerevan",
      "country": {
        "id": 8,
        "name": "Armenia",
        "iso_code": "AM",
        "phone_code": "374"
      },
      "currency": {
        "id": 2,
        "name": "Armenian Dram",
        "code": "AMD",
        "prepend": null,
        "append": " AMD",
        "thousand_separator": ".",
        "decimal_separator": ","
      }
    },
    "tms_instance": {
      "id": 1,
      "name": "ACNO",
      "identifier": "acno",
      "base_url": "http://connect.test",
      "bearer_token": "3491234030430042304230403",
      "legal_entity": {
        "id": 1,
        "name": "Legal Entity Example",
        "organization_number": "23532532523",
        "contact_person": "John Doe",
        "phone": "+37870001780",
        "email": "johnDoe@mail.com",
        "address_line": "Address 38, 32",
        "address_postal_code": "324212",
        "address_city": "Yerevan",
        "country": {
          "id": 8,
          "name": "Armenia",
          "iso_code": "AM",
          "phone_code": "374"
        },
        "currency": {
          "id": 2,
          "name": "Armenian Dram",
          "code": "AMD",
          "prepend": null,
          "append": " AMD",
          "thousand_separator": ".",
          "decimal_separator": ","
        }
      }
    },
    "invoice_lines": [
      {
        "id": 58,
        "vat_percentage": 20,
        "quantity": 5,
        "unit_net_amount": 50,
        "net_amount": 250,
        "vat_amount": 50,
        "gross_amount": 300,
        "description": "The description of the first line",
        "comment": "The comment of the first line"
      },
      {
        "id": 59,
        "vat_percentage": 10,
        "quantity": 10,
        "unit_net_amount": 100,
        "net_amount": 1000,
        "vat_amount": 100,
        "gross_amount": 1100,
        "description": "The description of the second line",
        "comment": "The comment of the second line"
      }
    ]
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific invoice in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v1/invoices/{invoice_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
status | string | **YES** | The status of the invoice. Can be `unpaid`, `paid` or `credited` 

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v1/invoices/{invoice_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "status": "credited"
    }'
```

### Example Response

```json
{
  "data": {
    "id": 12,
    "uuid": "33d82acd-04bb-48df-8834-f66c5942fb4f",
    "invoice_number": 12,
    "type": "invoice",
    "status": "credited",
    "date": "2021-08-31",
    "bank_account": "30445553030002",
    "reference": "31023012032",
    "net_amount": 1250,
    "vat_amount": 150,
    "gross_amount": 1400,
    "credit_note_id": 18,
    "currency": {
      "id": 2,
      "name": "Armenian Dram",
      "code": "AMD",
      "prepend": null,
      "append": " AMD",
      "thousand_separator": ".",
      "decimal_separator": ","
    },
    "client": {
      "id": 1,
      "uuid": "1b4fb590-98ae-4a7e-a860-34d08e84b154",
      "name": "GURAM AS",
      "type": "business",
      "country": {
        "id": 1,
        "name": "Afghanistan",
        "iso_code": "AF",
        "phone_code": "93"
      },
      "id_number": "ID392922939",
      "vat_identifier": "1341242"
    },
    "legal_entity": {
      "id": 1,
      "name": "Legal Entity Example",
      "organization_number": "23532532523",
      "contact_person": "John Doe",
      "phone": "+37870001780",
      "email": "johnDoe@mail.com",
      "address_line": "Address 38, 32",
      "address_postal_code": "324212",
      "address_city": "Yerevan",
      "country": {
        "id": 8,
        "name": "Armenia",
        "iso_code": "AM",
        "phone_code": "374"
      },
      "currency": {
        "id": 2,
        "name": "Armenian Dram",
        "code": "AMD",
        "prepend": null,
        "append": " AMD",
        "thousand_separator": ".",
        "decimal_separator": ","
      }
    },
    "tms_instance": {
      "id": 1,
      "name": "ACNO",
      "identifier": "acno",
      "base_url": "http://connect.test",
      "bearer_token": "3491234030430042304230403",
      "legal_entity": {
        "id": 1,
        "name": "Legal Entity Example",
        "organization_number": "23532532523",
        "contact_person": "John Doe",
        "phone": "+37870001780",
        "email": "johnDoe@mail.com",
        "address_line": "Address 38, 32",
        "address_postal_code": "324212",
        "address_city": "Yerevan",
        "country": {
          "id": 8,
          "name": "Armenia",
          "iso_code": "AM",
          "phone_code": "374"
        },
        "currency": {
          "id": 2,
          "name": "Armenian Dram",
          "code": "AMD",
          "prepend": null,
          "append": " AMD",
          "thousand_separator": ".",
          "decimal_separator": ","
        }
      }
    },
    "invoice_lines": [
      {
        "id": 58,
        "vat_percentage": 20,
        "quantity": 5,
        "unit_net_amount": 50,
        "net_amount": 250,
        "vat_amount": 50,
        "gross_amount": 300,
        "description": "The description of the first line",
        "comment": "The comment of the first line"
      },
      {
        "id": 59,
        "vat_percentage": 10,
        "quantity": 10,
        "unit_net_amount": 100,
        "net_amount": 1000,
        "vat_amount": 100,
        "gross_amount": 1100,
        "description": "The description of the second line",
        "comment": "The comment of the second line"
      }
    ]
  }
}
```