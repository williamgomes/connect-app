# Contracts

---

- [Create](#create)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the contract object.
active | boolean | Determines if the contract is active or not.
client_id | integer | The ID of the client the contract is assigned to.
start_date | string | The start date of the contract.
end_date | string | The end date of the contract.
one_time | boolean | The one time of the contract.
under_50_bills | boolean | The under 50 bills of the contract.
shareholder_registry | boolean | The shareholder registry of the contract.
control_client | boolean | The control client of the contract.
bank_reconciliation | boolean | The bank reconciliation of the contract.
bank_reconciliation_date | string | The bank reconciliation date of the contract.
bank_reconciliation_frequency | boolean | The bank reconciliation frequency of the contract.
bookkeeping | bookkeeping | The bookkeeping of the contract.
bookkeeping_date | string | The bookkeeping date of the contract.
bookkeeping_frequency_1 | string | The bookkeeping frequency 1 of the contract.
bookkeeping_frequency_2 | string | The bookkeeping frequency 2 of the contract.
mva | bookkeeping | The mva of the contract.
mva_type | integer | The mva type of the contract.
financial_statements | boolean | The financial statements of the contract.
financial_statements_year | integer | The financial statements year of the contract.
salary_check | boolean | The salary check of the contract.
salary | boolean | The salary of the contract.
created_by | string | The ID of the contract creator.

<a name="create"></a>
## Create

This endpoint creates a contract with given client in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/clients/{client_id}/contracts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The ID of the client the contract is assigned to.
active | boolean | No | Determines if the contract is active or not.
start_date | string | **Yes** | The start date of the contract.
end_date | string | No | The end date of the contract.
one_time | boolean | **Yes** | The one time of the contract.
under_50_bills | boolean | **Yes** | The under 50 bills of the contract.
shareholder_registry | boolean | **Yes** | The shareholder registry of the contract.
control_client | boolean | No | The control client of the contract.
bank_reconciliation | boolean | **Yes** | The bank reconciliation of the contract.
bank_reconciliation_date | string | No | The bank reconciliation date of the contract.
bank_reconciliation_frequency_custom | boolean | **Yes** | The bank reconciliation custom frequency of the contract.
bank_reconciliation_frequency | string | No | The bank reconciliation frequency of the contract.
bookkeeping | boolean | **Yes** | The bookkeeping of the contract.
bookkeeping_date | string | No | The bookkeeping date of the contract.
bookkeeping_frequency_custom | boolean | **Yes** | The bookkeeping custom frequency of the contract.
bookkeeping_frequency_1 | string | No | The bookkeeping frequency 1 of the contract.
bookkeeping_frequency_2 | string | No | The bookkeeping frequency 2 of the contract.
mva | boolean | **Yes** | The mva of the contract.
mva_type | integer | No | The mva type of the contract.
financial_statements | boolean | **Yes** | The financial statements of the contract.
financial_statements_year | integer | No | The financial statements year of the contract.
salary_check | boolean | **Yes** | The salary check of the contract.
salary | boolean | **Yes** | The salary of the contract.
salary_day | array | No | The array of salary payment days of month.
salary_day.* | integer | No | The salary payment day of month.
created_by | string | No | The ID of the user who created the contract.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/clients/{client_id}/contracts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
          "start_date": "2018-09-13",
          "one_time": false,
          "under_50_bills": false,
          "shareholder_registry": false,
          "control_client": true,
          "bank_reconciliation": false,
          "bank_reconciliation_frequency_custom": false,
          "bookkeeping": false,
          "bookkeeping_frequency_custom": false,
          "mva": true,
          "mva_type": 1,
          "financial_statements": true,
          "financial_statements_year": 2018,
          "salary_check": false,
          "salary": true,
          "salary_day": [
            1,
            2
          ]
        }'
```

### Example Response

```json
{
  "data": {
    "id": 2456,
    "client_id": 3678,
    "active": true,
    "start_date": "2018-09-13",
    "end_date": "",
    "one_time": false,
    "under_50_bills": false,
    "shareholder_registry": false,
    "bank_reconciliation": false,
    "bank_reconciliation_date": null,
    "bank_reconciliation_frequency_custom": false,
    "bank_reconciliation_frequency": "2 months 10",
    "bookkeeping": false,
    "bookkeeping_date": null,
    "bookkeeping_frequency_custom": false,
    "bookkeeping_frequency_1": "1 months 15",
    "bookkeeping_frequency_2": "2 months 10",
    "mva": true,
    "mva_type": 1,
    "financial_statements": true,
    "financial_statements_year": 2018,
    "salary_check": false,
    "salary": true,
    "salary_days": [
      {
        "id": 414,
        "day": 1
      },
      {
        "id": 415,
        "day": 2
      }
    ]
  }
}
```


