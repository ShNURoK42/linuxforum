<?php
namespace tests\codeception\unit\user\models;

use Yii;
use yii\codeception\TestCase;
use user\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends TestCase
{
    use Specify;

    /**
     * @var LoginForm
     */
    public $model;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function setUp()
    {
        parent::setUp();
        $this->model = new LoginForm(['scenario' => LoginForm::SCENARIO_DEFAULT]);
    }

    public function testEmailValidation()
    {
        $this->specify("email is required", function() {
            $this->model->email = null;
            expect("email should not be empty", $this->model->validate(['email']))->false();
        });

        $this->specify("email is trimed", function() {
            $this->model->email = '   asd@asd.com';
            $this->model->validate(['email']);
            expect("email should be trimed left", $this->model->email)->same('asd@asd.com');

            $this->model->email = 'asd@asd.com   ';
            $this->model->validate(['email']);
            expect("email should be trimed right", $this->model->email)->same('asd@asd.com');

            $this->model->email = '   asd@asd.com   ';
            $this->model->validate(['email']);
            expect("email should be trimed both side", $this->model->email)->same('asd@asd.com');
        });

        $this->specify("email is valid email adress", function() {
            $this->model->email = 'John Smith <smith@example.com>';
            expect("email should not be with name", $this->model->validate(['email']))->false();

            $this->model->email = 'asd@mail.ru';
            expect("property `email` should be without name", $this->model->validate(['email']))->true();
        });
    }

    public function testDuration()
    {
        $this->specify("", function() {
            expect("property `duration` should be `1209600` by default", $this->model->getDuration())->same(1209600);
            $this->model->setDuration(123);
            expect('property `duration` should be setting/getting by method', $this->model->getDuration())->same(123);
            $this->model->duration = 123;
            expect('property `duration` should be setting/getting by property', $this->model->duration)->same(123);
        });
    }
}