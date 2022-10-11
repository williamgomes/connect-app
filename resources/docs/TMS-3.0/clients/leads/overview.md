# Leads

---

- [Create](#create)

### Model

Parameter | Type | Description
--------- | ---- | -----------
type | string | The type of the client 
client_id | integer | The ID of the actual client if the lead was won 
manager_id | integer | The unique ID of the manager of the client 
employee_id | integer | The unique ID of the employee (consultant) of the client 
name | string | The name of the client 
organization_number | string (digits:9) | The organization number of the client 
system_id | integer | The system ID of the client 
customer_type | integer | The customer type of the client 
invoice_contact_email_id | integer | The default contact email ID to be used in invoices 
contact_email_id | integer | The default contact email ID 
contact_phone_id | integer | The default contact phone ID 
paid | boolean | Determines if the client is paid or not 
active | boolean | Determines if the client is active or not 
paused | boolean | Determines if the client is paused or not 
newsletter | boolean | Determines if subscribed to newsletters or not 
created_at | datetime | The date of the client creation 
updated_at | datetime | The date of the client last update

<a name="create"></a>
## Create

This endpoint creates a lead type client in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/leads`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_name | string | No (required if no *organization_number*) | The name of creating lead's contact  
contact_email | string | No (required if no *contact_phone*) | The email of creating lead's contact  
contact_phone | integer | No (required if no *contact_email*) | The phone of creating lead's contact  
type | string | No | The type of the lead, default to `client_lead`. Can also be `user_lead`.
organization_number | integer | No | The organization number of the lead 
lead_task_id | integer | No | The lead task ID which will be created and assigned to the lead 
client_note | string | No | The note to be created on first lead task 

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/leads \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "type": "user_lead",
        "contact_name": "John Doe", 
        "contact_email": "john.doe@synega.com", 
        "contact_phone": "4712341234", 
        "lead_task_id": 1,
        "client_note": "A note oges here"
    }'
```

### Example Response

```json
{
  "data": {
    "id": 3679,
    "name": "John Doe",
    "type": "user_lead",
    "organization_number": null,
    "system": {
      "id": 5,
      "name": "Unknown",
      "visible": false,
      "default": true
    },
    "customer_type": null,
    "manager": null,
    "employee": null,
    "invoice_contact_email": null,
    "contact_email": null,
    "contact_phone": null,
    "paid": true,
    "active": true,
    "paused": false,
    "newsletter": false
  }
}
```
