<?php
App::uses('Component', 'Controller');
/*
 * This class provides all of the needed logic in order to import a MealMaster type recipe(s)
 */

class MealMasterComponent extends Component {

    var $MMCategories = array();
    
    /*
     * Keep track of the current recipe being examined
     */
    
    var $currentRecipe = NULL;
    var $currentIngredient = NULL;
    var $ingredientList = array();	
    
    /*
     * Define some reg ex parts to look for
     */
    
    var $rxpHead = '/^(M{5,5}|-{5,5}).*Meal-Master/';
    //var $rxpEnd = '/^(M{5,5}|-{5,5})\s$/';
    // Added to fix bug reported to user, use the previous regex if this fails.
    var $rxpEnd = '/^(M{5,5}|-{5,5})(-{5,5})?\s*$/';

    var $rxpTitle = '/^ *Title: .+/';
    var $rxpCat = '/^ *Categories: .+/';
    var $rxpYield = '/^ *(Yield:|Servings:) +[1-9][0-9]*/';
    var $rxpWhitespaceOnly = '/^\\s+$/';
    // example group line: MMMMM----------------SAUCE-----------------
    var $rxpGroup = '/^(MMMMM|-----).*(-)+$/';
    var $rxpSeparator = '/^(MMMMM|-----)/';
    
    /*
     * Define the Units and there equiv in this program, they are looked up in unitdefs later
     */
    
    var $MMUnits = array(
			 'x' =>  'unit',		//Per serving
			 'cn' => 'can',			//Can
			 'pk' => 'package',		//Package
			 'pn' => 'pinch',
			 'dr' => 'drop',
			 'ds' => 'dash',
			 'ct' => 'carton', 		//Carton
			 'bn' => 'bunch', 		//Bunch
			 'sl' => 'slice',
			 'ea' => 'unit',		//Each
			 't'  => 'teaspoon',
			 'ts' => 'teaspoon',
			 'T'  => 'tablespoon',
			 'tb' => 'tablespoon',
			 'fl' => 'ounce',
			 'c'  => 'cup',
			 'pt' => 'pint',
			 'qt' => 'quart',
			 'ga' => 'gallon',
			 'oz' => 'ounce',
			 'lb' => 'pound',
			 'ml' => 'milliliter',
			 'cc' => 'cubic Centimeter',
			 'cl' => 'centiliter',
			 'dl' => 'deciliter',
			 'l'  => 'liter',
			 'mg' => 'milligram',
			 'cg' => 'centigram',
			 'g'  => 'gram',
			 'kg' => 'kilogram'
			 );
    
    /*
     * Some MM units are really qualifiers
     */
    
    var $MMQualifiers = array(
			      'sm' => 'small',
			      'md' => 'medium',
			      'lg' => 'large'
			      );

    /**
            Gets the data out of the given data file and loads it into the importRecipes, relatedRecipes arrays
            @param $file The file to parse
    */
    function parseDataFile($file) {
            if (!($fp = fopen($file, "r"))) {
                    die(__('could not data file for reading'). "<br />");
            }
            $this->parseDataFileImpl($fp); // call the function that is implementing the import
            fclose($fp); // close the data file
    }
    
    /*
     * Entry point for parsing Meal Master File
     * @param $fp File pointer to an upload MealMaster file
     * @return true if successful, false if failure
     */
    
    function parseDataFileImpl($fp)
    {
	/* start */
	
	$this->readAllRecipes($fp);
/*	print "<pre>";
	print_r($this->importRecipes);
	print "</pre>"; */
	
	// Do not throw exception if user was interrupting the input.
	if (empty($this->importRecipes)) {
	    print "File does not contain any Meal-Master recipe(s).<br />\n";
	    return false;
	}
	return true;
    }

    function readAllRecipes($fp)
    {
	
	while (!feof($fp)) {
	    $data = fgets($fp, 256);
	    if (preg_match($this->rxpHead, $data)) {
		// if we have a header string, we can skip it :)
		$data = fgets($fp, 256);
		/*
		 * We might have a recipe here. Copy everything up to the end
		 * of the recipe to a separate string list and pass that on
		 * for further examination.
		 */
		$end = false;
		// copy recipe into internal string list
		while (!$end) {
		    $this->curRecipeString[] = $data;
		    if ((preg_match($this->rxpEnd, $data)) || ( feof($fp) ) )
		      $end = true;
		    else
		      $data = fgets($fp, 256);
		}
		unset($data);
		$this->readRecipe();
	    } // recipe found
	} // while
    } // readAllRecipes();


    /* this function gets called once for every recipe
     */
    
    function readRecipe()
    {
	$this->currentRecipe = array();
	$this->ingredientList = array();

	$this->readRecipeHeader();
	$this->readRecipeBody();
	if (!empty($this->currentRecipe['name'])) {
	    $this->importRecipes[] = array ($this->currentRecipe, $this->ingredientList);
	}
	
	/* write the recipe to the database here, for memory reasons */
	
	/* clean up */
	unset($this->curRecipeString);
	unset($this->ingredientList);
	unset($this->currentRecipe);
    } // readRecipe

    /*
     * The header contains the title, catagories, and yield information.
     */
    
    function readRecipeHeader()
    {
	
	// done when we got title, categories, and yield information
	$done = false;
	$gotTitle = $gotCategories = $gotYield = false;
	
	while (!$done) {
	    // skip initial header line
	    if (preg_match($this->rxpHead, $this->curRecipeString[0])) {
		unset($this->curRecipeString[0]);
		$this->curRecipeString = array_values($this->curRecipeString);
		continue;
	    }
		
	    // Ignore empty lines.
	    if ((empty($this->curRecipeString[0])) || (preg_match($this->rxpWhitespaceOnly, $this->curRecipeString[0]))) {
		unset($this->curRecipeString[0]);
		$this->curRecipeString = array_values($this->curRecipeString);
		continue;
	    }
	    
	    /* check if it's a title */
	    if (preg_match($this->rxpTitle, $this->curRecipeString[0])) {
		$pos = strpos($this->curRecipeString[0], "Title: ") + strlen("Title: ");
		$this->currentRecipe['name'] = htmlspecialchars(trim(substr($this->curRecipeString[0], $pos)), ENT_QUOTES);
                //print "Title : " . $this->currentRecipe['name'] . "<br />\n";
		$gotTitle = true;
	    /* check it it's a categories listing */
	    } else if (preg_match($this->rxpCat, $this->curRecipeString[0])) {
		$pos = strpos($this->curRecipeString[0], "Categories: ") + strlen("Categories: ");
		$this->addCategories( substr($this->curRecipeString[0], $pos) );
                //print "Categories... some random<br />\n";
		$gotCategories = true;
	    /* check if it's our Yield string */
	    } else if (preg_match($this->rxpYield, $this->curRecipeString[0])) {
		if (strpos($this->curRecipeString[0], "Yield")) {
		    $pos = strpos($this->curRecipeString[0], "Yield: ") + strlen("Yield: ");
		} else {
		    $pos = strpos($this->curRecipeString[0], "Servings: ") + strlen("Servings: ");
		}
		$yieldStr = trim(substr($this->curRecipeString[0], $pos));
		// clean out any possible text before and after the yield number
		$this->currentRecipe['serving_size'] = intval($yieldStr);
                //print "Yield : " . $this->currentRecipe['serving_size']. "<br />\n";
		/* everything after the yield number is treated as the yield unit
		 * but we don't use that at the moment */
		$gotYield = true;
	    }
	    
	    if (($gotTitle) && ($gotCategories) && ($gotYield))
	      $done = true;
	    unset($this->curRecipeString[0]);
	    $this->curRecipeString = array_values($this->curRecipeString);
	}
    } // readRecipeHeader()
    
    /*
     * The recipe body contains ingredients, references, and preparation steps.
     * 
     * \bug (B) Ingredients: retrieving amounts like "1 1/2",
     *        possible solution: use hardcoded string indexes (field lengths).
     */
    function readRecipeBody()
    {
	$this->currentIngredient = new Ingredient();
	$this->readRecipeIngredients();
	$this->readRecipeSteps();
    }

    /*
     * Read in all ingredients.
     * 
     * This function contains an internal list of strings that identify
     * a references line. These strings are hardcoded and not subject to
     * the normal i18n mechanism.
     * 
     * todo: Provide a way for the user to manipulate the internal list of
     *       strings identifying a references line.
     */
    function readRecipeIngredients()
    {
	// The current ingredient category
	$curGroup = NULL;
	
	// Skip empty line(s) at the beginning.
	while ((empty($this->curRecipeString[0])) || (preg_match($this->rxpWhitespaceOnly, $this->curRecipeString[0]))) {
	    unset($this->curRecipeString[0]);
	    $this->curRecipeString = array_values($this->curRecipeString);
	}
	
	$stop = FALSE;
	while (!$stop) {              // iterate all lines
	    // Ingredients are done at the first line not representing an ingredient
	    if (!$this->mightBelong2Ingredients($this->curRecipeString[0])) {
		break;
	    }
	    
	    /* In case we find a reference line:
	     *   open a new ingredient category
	     */
	    if (preg_match($this->rxpGroup, trim($this->curRecipeString[0]))) {
		// save the ingredient, if we have one
		if (trim($this->currentIngredient['name']) != NULL) {
		    $this->ingredientList[] = $this->currentIngredient;
		    $this->currentIngredient = array();
		}
		
		$this->curRecipeString[0] = preg_replace( '/^M{5,5}/', "", $this->curRecipeString[0]); // remove initial "M"s
		$this->curRecipeString[0] = preg_replace( '/^-*/', "", $this->curRecipeString[0]); // remove dashes up to category name
		$this->curRecipeString[0] = preg_replace( '/-*$/', "", trim($this->curRecipeString[0])); // remove dashes after category name
		$this->curRecipeString[0] = trim($this->curRecipeString[0]); // cut unwanted whitespaces
		$curGroup = $this->curRecipeString[0];        // The rest is our new category.
		print "New group: $curGroup<br />\n";
		unset($this->curRecipeString[0]);                // next line
		$this->curRecipeString = array_values($this->curRecipeString);
		continue;
	    }
	    
	    $contLastI = $this->readIngredientLine($this->curRecipeString[0]);
	    if (!$contLastI) {
                if (!empty($this->currentIngredient['name'])) {
                    $this->ingredientList[] = $this->currentIngredient;
                    //print "Ingredient: ".$this->currentIngredient['name']." <br />\n";
                    unset($this->currentIngredient);
                    $this->currentIngredient = array();
                }
	    } else {
                if (count($this->ingredientList) > 0)
                  $this->ingredientList[count($this->ingredientList)-1]['name'] .= " " . htmlspecialchars(trim($this->currentIngredient['name']), ENT_QUOTES);
                else
                  $this->ingredientList[] = $this->currentIngredient;
	    }
	 
	    unset( $this->curRecipeString[0]);                   // next line
	    $this->curRecipeString = array_values($this->curRecipeString);
	}
    } // readRecipeIngredients()
    
    /*
     * $line: the line to be parsed
     * returns: true if the previous line was continued, false if new ingredient started.
     * 
     */

    function readIngredientLine($line)
    {
	$contLastLine = false;
	
	/*
	 * Extract the three parts of a ingredient (name, amount, measurement)
	 * into separate strings. They are separated according to their length:
	 *   amount: columns 0-6
	 *   measurement: columns 8-9
	 *   name: columns 11+
	 */
	$amount = substr( $line, 0, 7); // col 0-6
	$measurement = substr( $line, 8, 2); // col 8-9
	$name = substr( $line, 11); // col 11+
	
	$amount = trim($amount);
	$measurement = trim($measurement);
	$name = trim($name);

	
	if (intval($amount) == 0 )
		$amount = $amount;
	else
	{
	 	$amount = Fraction::strToFloat($amount);
	}

	if ($name != "" && $name[0] == '-' && $name[1] != '-') { // continue previous ingredient line.
	    $contLastLine = true;
	    trim($name);
	    $name = trim(preg_replace("/^-+/", " ", $name)); // remove all leading "-" chars
	    $this->currentIngredient['name'] = htmlspecialchars($name, ENT_QUOTES);;
            //print "readIngredientLine: Extra matches: $name <br />\n";
	} else {                     // just an ordinary ingredient line
	    $this->currentIngredient['quantity'] = $amount;
	    $this->setUnit($measurement);
	    $this->currentIngredient['name'] = htmlspecialchars($name, ENT_QUOTES);
            //print "readIngredientLine: Ingredient: $name <br />\n";
	}
	
	return $contLastLine;
    } // bool readIngredientLine
    
    /*
     * Returns whether or not the string \a line is possibly part of a
     *  recipe's ingredient block.
     */

    function mightBelong2Ingredients( $line )
    {
	// Empty lines are valid. Group lines, too.
	if ((empty($line)) || (preg_match($this->rxpWhitespaceOnly, $line)) || (preg_match($this->rxpSeparator, $line))) {
	    if (!preg_match($this->rxpEnd, $line))
	      return TRUE;
	} else {
	    /*
	     * There needs to be a blank at columns 7 and 10
	     *     (before/after the measurement)
	     */
	    if ($line[7] == ' ')
	      if ($line[10] == ' ')
		// Starting at column 11, the line must not be empty
		if (strlen(rtrim($line)) > 10) {
		      return TRUE;
		}
	}
	return FALSE;
    } // mightBelong2Ingredients() 

    /*
     * Even though a recipe should be ended by the MMMMM mark, check for end of
     * string, too.
     */

    function readRecipeSteps()
    {
	$skipLines = true;
	while (true) {
	    if ((empty($this->curRecipeString[0])) || (preg_match($this->rxpEnd, $this->curRecipeString[0])))
	      break;
	    
	    // Skip initial empty line(s).
	    if ($skipLines && (empty($this->curRecipeString[0])) || preg_match($this->rxpWhitespaceOnly, $this->curRecipeString[0])) {
		unset($this->curRecipeString[0]);
		$this->curRecipeString = array_values($this->curRecipeString);
		continue;
	    }
	    $skipLines = false;
	    
	    $this->currentRecipe['directions'] .= htmlspecialchars($this->curRecipeString[0], ENT_QUOTES);
	    // echo "Found directions: ".$this->curRecipeString[0]."<br />";
								    
	    unset($this->curRecipeString[0]);
	    $this->curRecipeString = array_values($this->curRecipeString);
	}
    } // readRecipeSteps()
    
    /**
     This function adds a list of categories to the current recipe. Because in Meal Master there is
     not separate field for base and course we will try to match it up as best we can
     @param $cat The category to look up
     @return the corresponding category ID.
     */
    function addCategories($cat) {
	$list = split(',', $cat);
	foreach ($list as $item) {
	    if ($key = $this->containsValue($this->bases, $item)) {
		$this->currentRecipe['base_type_id'] = $this->bases[$key];
	    } else if ($key = $this->containsValue($this->courses, $item)) {
		$this->currentRecipe['course_id'] = $this->courses[$key];
	    } else if ($key = $this->containsValue($this->ethnicity, $item)) {
		$this->currentRecipe['ethnicity_id'] = $this->ethnicity[$key];
	    }
	}
    } // addCategories
    
    /**
     * Tests to see if an array contains a given value, this is for a hash array (converts to lower case)
     *   @param $arr The array to test
     *   @param $val The val to look for
     *   @return true, if in array, otherwise false.
     */
    
    function containsValue($arr, $val) {
	foreach ($arr as $k=>$v) {
	    if (trim(strtolower($k)) == trim(strtolower($val))) return $k;
	}
	return 0;
    } // containsValue
    
    /*
     *                 Converts the Meal Master Units into our units
     *                 @param $unit The Unit to add to the current ingredient
     *
     */
    
    function setUnit($unit) {
	global $LangUI, $g_rb_unitmap;
	$unit = trim($unit);
	// Set as a default ea=unit
	if ($unit == '') $unit='ea';
	
	if ($unit == 'x') {
	    echo "A dynamic one!! Deal with it later... $unit<br />";
	} else {
	    // Do a look up on it.
	    if ($this->MMUnits[$unit]) {
		$this->currentIngredient['unit_id'] = $g_rb_unitmap[($this->MMUnits[$unit])];
		//$this->currentIngredient->unitMap = $this->currentIngredient->unit;
	    }
	    // See if we can get qualifier information out of it
	    if (isset($this->MMQualifiers[$unit])) {
		$this->currentIngredient['qualifier'] = $this->MMQualifiers[$unit];
	    }
	}
    }

    
} // class Import_MM

?>    
