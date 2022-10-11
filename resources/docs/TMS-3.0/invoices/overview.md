# Invoices

---

- [Average amount](#average)

<a name="average"></a>
## Average amount

This endpoint provides average amount of invoices in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/invoices/average`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
days | integer | No | The time records of last {days} days included in invoice average. Default is 90 days.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/invoices/average \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "days": 60
    }'
```

### Example Response

```json
{
  "data": {
    "amount": 1554.71
  }
}
```
