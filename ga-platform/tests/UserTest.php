<?php

class UserTest extends TestCase
{
     /**
     * @var FakerGenerator
     */


    protected $faker = null;
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */


    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    /**
    * Model Classes
    */
    protected $GAOffices = null;   
    public function setUp()
    {
        parent::setUp();
        $this->baseUrl = 'http://'.env('APP_HOST');
        $this->faker = Faker\Factory::create();
    
        Session::start();
	
		$this->visit('intranet/login')
             ->type('greatgnt', '#username')
             ->type('greater4gent!','#password')
             ->press('Sign In')
             ->seePageIs('intranet/dashboard');
		
		$user = new GAPlatform\User(array('name' => 'greatgnt'));
    	$this->be($user);
    }

    /**
     * My test implementation
     */


	public function testFoo()
	{
        $this 	-> 	visit('/intranet/dashboard')
             	->	click('All Users')
             	->	seePageIs('/intranet/users');

 		$this 	-> 	visit('/intranet/offices')
             	->	see('Office');


 		$this 	-> 	visit('/intranet/offices')
 				->  click('#info')
             	->	see('Offices - main information');
             	
         $this 	-> 	visit('/intranet/agents')
 				->  type('8', 'search')
 				->  press('Search')
 				->  seePageIs('/intranet/agents//')
             	->	see('Lisa Edwards');     	

	}


 public function AnyNewTest () {
        $this->action('GET', 'Intranet\OfficesController@infoOffices');
        $this->assertResponseOk();

        $this->action('GET', 'Intranet\UsersController@formUser');
        $this->assertResponseOk();
        $this->assertViewHas('user');

        $this->action('GET', 'Intranet\AgentsController@charges_get', 'cus_8IryVpEwMklKf6');
        $this->assertResponseOk();

        $response1 = $this->action('GET', 'Intranet\AgentsController@charges_get', 'cus_8IryVpEwMklKf6');
        			 $this->assertResponseOk();
        			 $this->assertTrue($response1->getContent());
        $response1 = $this->action('GET', 'Intranet\AgentsController@charges_get', '1');
        			 $this->assertResponseOk();
        			 $this->assertEquals(null, $response1); 

		$response1 = $this->action('GET', 'Intranet\AgentsController@charges_calc');
					 $this->assertResponseOk();
					 $this->assertEquals(null, $response1); 

		$response1 = $this->action('GET', 'Intranet\AgentsController@charges_calc',$response1);
					 $this->assertResponseOk();
					 $this->assertTrue($response1->getContent());
		$response1 = $this->action('GET', 'Intranet\AgentsController@formAgent');
					 $this->assertResponseOk();
					 $this->assertTrue($response1->getContent());

		$response1 = $this->action('GET', 'Intranet\OfficesController@subscriptions_get','cus_8JPC65OiwtqxwS');
					 $this->assertResponseOk();
					 $this->assertEquals(1, count($response1)); 
					 $this->assertTrue($response1->getContent());

    }



 /* Testing VIEWS */
 	public function testSimpleView() {        	
    	$res = $this->call('GET', '/intranet/agents');
	    $this->assertResponseOk();
	    $this->assertViewHas('items');
	    $items = $res->original['items'];
	    $this->assertEquals(1, count($items));  
		
		$res = $this->call('GET', '/intranet/offices');
	    $this->assertResponseOk();
	    $this->assertViewHas('items');

		$res = $this->call('GET', '/intranet/users');
	    $this->assertResponseOk();
	    $this->assertViewHas('items');
	   	$items = $res->original['items'];
	    $this->assertEquals(10, count($items)); 

	    $response = $this->get('/intranet/dashboard');
        $this->assertResponseOk();
	}


	/**
 	* @dataProvider providerTestNewUsers
 	*/
    public function testNewUsers($variableOne)
    {
    	$this->visit('/intranet/users/form')
    		 ->type($this->faker->name, 'Name')
    		 ->type($this->faker->email, 'Email')
			 ->type($this->faker->url, 'URL')
			 ->type($variableOne, 'Title')
			 ->press('Submit');

		$this->SeeInDatabase('GA_User', ['Title' => $variableOne]);

		// try to edit user data's
		$Query = DB::table('GA_User')->where('Title',$variableOne)->first();
		$this->visit('intranet/users/form/'.$Query->UserID.'/')
			 ->type('this_is_fake@mail.com', 'Email')
			 ->type($variableOne, 'Title')
			 ->press('Submit');

		$this->SeeInDatabase('GA_User', ['Email' => 'this_is_fake@mail.com']);
	}



	public function testNewAgentsWithError()
    {
		
    	$this->visit('/intranet/agents/form')
			 ->press('Submit')
			 ->seePageIs('/intranet/agents/form//')
			 ->see('Name is required');
		$this->assertResponseOk();
    }

	public function testNewOfficeWithError()
    {
		
    	$this->visit('/intranet/offices/form')
			 ->press('Submit')
			 ->seePageIs('/intranet/offices/form//')
			 ->see('Name is required');
		$this->assertResponseOk();
    }


	/**
	* @dataProvider providerTestNewAgents
 	*/
    public function testNewAgents($variableOne, $variableTwo, $varUser)
    {
		
		$Query = DB::table('GA_User')
					->where('UserID',$varUser)
					->where('Status','active')
					->first();
		if ($Query->UserID != 8) {
        $Us = $Query->UserID.' - '.$Query->Name;

    	$this->visit('/intranet/agents/form')
    		 ->type($this->faker->name, 'Name')
    		 ->type($this->faker->email, 'Email')
			 ->select($varUser, 'UserID')
			 ->type($variableOne, 'Office')
			 ->type('Title Field', 'Title')
			 ->type($variableTwo,'StripeCustomerID')
			 ->press('Submit');

		$this->SeeInDatabase('GA_SalesPerson', ['Office' => $variableOne, 'StripeCustomerID' => $variableTwo]);
		}
    }


	/**
	* @dataProvider providerTestNewAgents
 	*/
    public function testEditAgents($variableOne, $variableTwo, $varUser)
    {
		$Query = DB::table('GA_SalesPerson')
					->where('UserID',$varUser)
					->first();

        // $Us = $Query->UserID.' - '.$Query->Name;
  
        
    	$this->visit('/intranet/agents/form/'.$Query->SalesPersonID.'/')
    		 ->type($this->faker->name, 'Name')
    		 ->type($this->faker->email, 'Email')
			 ->type($variableOne, 'Office')
			 ->type('Title Field', 'Title')
			 ->type($variableTwo,'StripeCustomerID')
			 ->press('Submit');

		$this->SeeInDatabase('GA_SalesPerson', ['Office' => $variableOne, 'StripeCustomerID' => $variableTwo]);
	
    }



	/**
 	* @dataProvider providerTestNewOffice
 	*/
    public function testNewOffice($variableOne)
    {

    	$URL_LOGO =  function () {return factory(GAPlatform\Models\GAOffice::class)->create()->Logo_URL;};
    	$DomainName =  function () {return factory(GAPlatform\Models\GAOffice::class)->create()->DomainName;};

        $this->visit('/intranet/offices/form')
            ->type($this->faker->name, 'Name')
            ->type($variableOne, 'UID')
            ->type($this->faker->email, 'Email')
            ->type('+12223332223', 'Phone')
            ->type('http://image.com/logo', 'Logo_URL')
            ->type('123', 'Logo_ID')
            ->type($this->faker->url, 'DomainName')
            ->check('isActive')
            ->press('Submit')
            ->seePageIs('/intranet/offices/form//');

			$this->SeeInDatabase('GAOffices', ['UID' => $variableOne]);			
    }

  



	public function TestAllOffice()
	{
		$Query = DB::table('GAOffices')->get();
		foreach ($Query as $value) {
	    	$Agents = DB::table('GA_SalesPerson')->where('Office', $value->UID)->get();
	    		foreach ($Agents as $ag) {
	    	 		$User = DB::table('GA_User')->where('UserID', $ag->$UserID);
	    	 		$this->visit('/intranet/offices/main/'.$value->id.'/')
	    	 	  	 	 ->see($User->Name)
	    	 	  		 ->see($value->UID);
	    		}
		}
	}


	/* DEL ALL TESTING DATAS */

	/**
 	* @dataProvider providerTestDelOffice
 	*/
    public function testDelOffice($variableOne)
    {

		$Query = DB::table('GAOffices')->where('UID',$variableOne)->get();
			foreach ($Query as $value) {
				 $this->visit('/intranet/offices/delete/'.$value->id.'/')
				 	  ->press('Delete office')
				 	  ->see('Successfully deleted');
			}
    }



	/**
 	* @dataProvider providerTestDELAgents
 	*/
    public function testDelAgents($variableOne, $variableTwo, $varUser)
    { 
    	if ($varUser!=8) { DB::table('GA_SalesPerson')->where('UserID', $varUser)->delete(); }
    }

	/**
 	* @dataProvider providerTestDelNewUsers
 	*/
	public function testDelUsers($variableOne)
    {
    	$Query = DB::table('GA_User')->where('Title','like',$variableOne)->where('status','!=','deleted')->get();
		foreach ($Query as $value) {
				 $this->visit('/intranet/users/delete/'.$value->UserID.'/')
				 	  ->press('Delete User')
				 	  ->see('Successfully deleted');
				 $this->notSeeInDatabase('GA_User', ['UserID' => $value->UserID, 'status' => 'active' ]);
				 $this->SeeInDatabase('GA_User', 	['UserID' => $value->UserID, 'status' => 'deleted']); 
			}
    }


	public function providerTestDelOffice () { return $this->providerTestNewOffice(); }
	public function providerTestNewOffice ()
	{
    	return array(
    			array ('333-444-333'), 
    			array ('222-333-222'),
    			array ('555-666-888'),
    			array ('888-333-454'),
    			);
	}

	public function providerTestDELAgents () { return $this->providerTestNewAgents();}
	public function providerTestNewAgents ()
	{
    	return array(
    			array ('512-619-6498', 'cus_8JPC65OiwtqxwS', '8'), 
    			array ('222-333-222', 'cus_8IryVpEwMklKf6', '113545'),
    			array ('555-666-888','', '113546'),
    			array ('888-333-454','','113547'),
    			);
	}



	/* for USER"S test */
	public function providerTestNewUsers()    { return $this->for_user_test_array(); }
	public function providerTestDelNewUsers() { return $this->for_user_test_array(); }

	public function for_user_test_array(){
			return array(
    	 			array ('Title1'), 
    				array ('Title2'),
    				array ('Title3'),
    				array ('Title4'),
    				);
	}

	public function providerTestFoo()
	{
	    return array(
    			    array('All Users', '/intranet/users'),
        			array('Create New User', '/intranet/users/form'),
        			array('All Agents', '/intranet/agents'),
        			array('Create New Agents', '/intranet/agents/form'),
        			array('All Offices', '/intranet/offices'),
        			array('Create New Offices', '/intranet/offices/form'),
        			array('Dashboard', '/intranet/dashboard'),      
    	);
	}

}

