<?php

namespace Tests\Unit\app\Http\Requests;

use App\Http\Requests\AdvertRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class AdvertRequestTest extends TestCase
{

    public function testValidationItShouldContainAllTheExpectedRules()
    {
        $request = new AdvertRequest();
        $this->assertEquals([
            'name' => ['required', 'string'],
            'from' =>  ['required', 'date', 'before:to'],
            'to' =>  ['required', 'date', 'after:from'],
            'total_budget' => ['required', 'numeric'],
            'daily_budget' => ['required', 'numeric'],
            "banners" => ['required', 'array'],
            'banners.*' => ['image', 'mimes:jpg,jpeg,png', 'max:10000'],
            'user_id' => ['required', 'numeric'],
            'id' => ['filled', 'numeric'],
        ], $request->rules());
    }

    public function testValidationShouldFailWhenRequiredFieldsAreMissing()
    {
        $request = new AdvertRequest();
        $validator = Validator::make([
            'name' => 'Test Name',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('from', $validator->errors()->keys());
        $this->assertContains('to', $validator->errors()->keys());
        $this->assertContains('total_budget', $validator->errors()->keys());
        $this->assertContains('daily_budget', $validator->errors()->keys());
        $this->assertContains('banners', $validator->errors()->keys());
        $this->assertContains('user_id', $validator->errors()->keys());
    }

    public function testValidationShouldFailWhenIdKeyIsSupplyWithEmptyValue()
    {
        $request = new AdvertRequest();
        $validator = Validator::make([
            'name' => 'Test Name',
            'from' =>  '2021-01-12',
            'to' =>  '2021-02-12',
            'total_budget' => 434433.08,
            'daily_budget' => 4343.08,
            'banners' => [],
            'user_id' => 1,
            'id' => '',
        ], $request->rules());

        $this->assertContains('id', $validator->errors()->keys());
    }

    public function testValidationShouldFailWhenUserIdIsString()
    {
        $request = new AdvertRequest();
        $validator = Validator::make([
            'name' => 'Test Name',
            'from' =>  '2021-01-12',
            'to' =>  '2021-02-12',
            'total_budget' => 434433.08,
            'daily_budget' => 4343.08,
            'banners' => [],
            'user_id' => "test should fail",
            'id' => 1,
        ], $request->rules());

        $this->assertContains('user_id', $validator->errors()->keys());
    }

    public function testValidationShouldFailWhenFromIsGreaterOrEqualTo()
    {
        $request = new AdvertRequest();
        $validator = Validator::make([
            'name' => 'Test Name',
            'from' =>  '2021-04-12',
            'to' =>  '2021-02-12',
            'total_budget' => 434433.08,
            'daily_budget' => 4343.08,
            'banners' => [],
            'user_id' => 1,
            'id' => '',
        ], $request->rules());

        $this->assertContains('to', $validator->errors()->keys());
    }
    public function testValidationShouldPasslWhenAllInputAreValid()
    {
        $files = [UploadedFile::fake()->createWithContent(name: 'banner1.png', content: 'random content'), UploadedFile::fake()->createWithContent(name: 'banner2.png', content: 'random content')];
        $request = new AdvertRequest();
        $validator = Validator::make([
            'name' => 'Test Name',
            'from' =>  '2021-01-12',
            'to' =>  '2021-02-12',
            'total_budget' => 434433.08,
            'daily_budget' => 4343.08,
            'banners' => $files,
            'user_id' => 1,
            'id' => 1,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }
}
