# Email Templates

---

- [Send](#send)

<a name="send"></a>
## Send

This endpoint sends an email template in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/email-templates/send`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
email_template_id | integer | **Yes** | The unique ID of the email template.
client_id | integer | No (required if no organization_number) | The unique ID of the email receiver client.
organization_number | integer | No (required if no client_id) | The unique organization number of the email receiver client.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/email-templates/send \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "email_template_id": 2,
       "client_id": 802
    }'
```

### Example Response

```http
HTTP/1.1 204 No Content
```
