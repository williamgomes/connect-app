<?php

namespace Tests;

use App\Models\Company;
use App\Models\Document;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * @return array
     */
    public function fakeProfilePicture(): array
    {
        $file = UploadedFile::fake()->image('profile_picture.jpg', 500, 600);

        return [
            'profile_picture' => $file,
            'crop_x'          => 400,
            'crop_y'          => 400,
            'crop_width'      => 500,
            'crop_height'     => 500,
        ];
    }

    /**
     * @return \Illuminate\Http\Testing\File
     */
    public function fakeDocument(): \Illuminate\Http\Testing\File
    {
        return UploadedFile::fake()->create('document', 500, 'csv');
    }

    /**
     * @param $user
     *
     * @return Document
     */
    public function storeFakeDocument($user): Document
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $fakeDocument = $this->fakeDocument();
        $filename = Storage::disk('s3')->putFile('documents', $fakeDocument);

        return Document::create([
            'user_id'     => $user->id,
            'uploaded_by' => $admin->id,
            'title'       => $fakeDocument->getClientOriginalName(),
            'filename'    => $filename,
        ]);
    }

    /**
     * Creating company with unique (country_id, service_id, directory_id) combination.
     *
     * @return array|\Illuminate\Http\Testing\File
     */
    public function fakeCompanyData()
    {
        $companyData = Company::factory()->make()->toArray();

        $existingCompany = Company::where([
            'country_id'   => $companyData['country_id'],
            'service_id'   => $companyData['service_id'],
            'directory_id' => $companyData['directory_id'],
        ])->exists();

        if (!$existingCompany) {
            return $companyData;
        }

        return $this->fakeCompanyData();
    }

    /**
     * Creating RoleUser with unique (company_id, role_id, user_id) combination.
     *
     * @return array|\Illuminate\Http\Testing\File
     */
    public function fakeRoleUserData()
    {
        $roleUserData = RoleUser::factory()->make()->toArray();

        $existingRoleUser = RoleUser::where([
            'company_id' => $roleUserData['company_id'],
            'role_id'    => $roleUserData['role_id'],
            'user_id'    => $roleUserData['user_id'],
        ])->exists();

        if (!$existingRoleUser) {
            return $roleUserData;
        }

        return $this->fakeRoleUserData();
    }
}
