<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('onelogin_tenant_url')->nullable();
            $table->string('onelogin_api_url')->nullable();
            $table->string('onelogin_client_id')->nullable();
            $table->string('onelogin_secret_key')->nullable();
            $table->unsignedInteger('onelogin_default_role')->nullable();
            $table->string('duo_integration_key')->nullable();
            $table->string('duo_secret_key')->nullable();
            $table->string('duo_api_url')->nullable();
            $table->string('saml_entity_id')->nullable();
            $table->string('saml_sso_url')->nullable();
            $table->string('saml_slo_url')->nullable();
            $table->string('saml_cfi')->nullable();
            $table->string('saml_contact_name')->nullable();
            $table->string('saml_contact_email')->nullable();
            $table->string('saml_organization_name')->nullable();
            $table->string('saml_website_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directories');
    }
}
