<?php

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('email', 191)->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        CompanyProfile::create(
        [
            'name'    => 'Link-Up Technology Ltd.',
            'phone'   => '+8801981800200',
            'email'   => 'mail@linktechbd.com',
            'address' => 'Road -3, Plot -16 (Bilal Uddin Mansion), 4th & 5th Floor, Mirpur 10 (Behind Shah Ali Plaza), Dhaka-1216.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_profiles');
    }
}
