# Check Authentication

---

- [Application](#application)

Applications are the way to authenticate with the Dashboard API. The authentication type is still the same (access token), however each access token is now linked with an application.
<br><br>
This means that an application will have to be created to then generate a token under the application. We do support multiple tokens under an application, this gives the flexibility of refreshing the access token on a regular schedule with zero downtime.

<a name="application"></a>
## Application

This endpoint show the currently authenticated application as well as access token application.

### HTTP Request

`GET https://{enviroment}.synega.com/api/v1/application`

### Example Request

```shell
curl -X GET https://{enviroment}.synega.com/api/v1/application \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 2,
    "identifier": "test-identifier",
    "application": {
      "id": 1,
      "name": "Test Application"
    }
  }
}
```

### Response Parameters

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique id for the access token used in the current request.
identifier | string | The unique identifier for the access token used in the current request.
application | object | An object including the application linked to the access token.
application.id | integer | The unique id for the application linked to the access token.
application.name | string | The unique name for the application linked to the access token.
