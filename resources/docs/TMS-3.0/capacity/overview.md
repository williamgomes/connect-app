# Capacity

---

- [Total Capacity](#total_capacity)
- [Available User](#available_user)

### Model

Parameter | Type | Description
--------- | ---- | -----------
actual_capacity | integer | The actual capacity.
possible_capacity | integer | The possible capacity.

<a name="total_capacity"></a>
## Total Capacity

This endpoint provides information about total raw capacity of TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/capacity/total`

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/capacity/total \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "actual_capacity": 99,
    "possible_capacity": 264
  }
}
```

> {primary} Be aware! Possible capacity is not a real capacity. That’s the capacity for the “dream sceanario” and is only to be used in applications using the factor to guess forward capacity. Any application that need real time capacity must use actual_capacity field.

<a name="available_user"></a>
## Available User

This endpoint returns an available user object for the new client.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/capacity/user`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
yearly_statement | boolean | **Yes** | The yearly statement.
system | integer | **Yes** | The ID of the system which the found user should be available for.
customer_type | integer | **Yes** | The ID of the customer type which the found user should be available for.
task_types | array | **Yes** | The array of task type IDs.
task_types.* | integer | No | The ID of the task type which the found user should be available for.
client_id | integer | No (required if no **client_level**) | The specific client ID which the found user should be available for.
client_level | integer | No (required if no **client_id**) | The client level which the found user should be available for.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/capacity/user \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "yearly_statement": 1,
        "system": 1,
        "customer_type": 1,
        "task_types[]": 1,
        "task_types[]": 2,
        "client_id": 600
    }'
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "synega_id": 100,
        "manager_id": 1,
        "external_id": null,
        "role": 10,
        "active": true,
        "level": 6,
        "name": "John Doe",
        "work_title": "Administrator",
        "email": "john.doe@synega.com",
        "phone": 4712341234,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "profile-picture-url"
    }
}
```

> {primary} Be aware! If we can't find a user, the endpoint will return a `404 Not Found` response.
