<?php
App::uses('AppModel', 'Model');
/**
 * ShoppingListName Model
 *
 * @property User $User
 * @property ShoppingListIngredient $ShoppingListIngredient
 * @property ShoppingListRecipe $ShoppingListRecipe
 */
class ShoppingList extends AppModel {


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
            'name' => array(
                'required' => array(
                  'rule' => 'notBlank'
                )
            ),
    );

    public $belongsTo = array(
            'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'user_id'
            ),
            'ListItem'
    );

    public $hasMany = array(
        'ShoppingListIngredient' => array(
                'className' => 'ShoppingListIngredient',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        ),
        'ShoppingListRecipe' => array(
                'className' => 'ShoppingListRecipe',
                'foreignKey' => 'shopping_list_id',
                'dependent' => true,
        )
    );
    
    public function getDefaultListId($userId) {
        $listId = $this->field('id', array('user_id' => $userId, 'name' => __('DEFAULT')));
        if (!isset($listId) || $listId == "") {
            $list = $this->getList($user);
            $listId = $list['ShoppingList']['id'];
        }
        return $listId;
    }
    
    public function getList($userId, $listId=null) {
        $this->Behaviors->load('Containable');
        $options = array(
            'contain' => array(
                'ShoppingListRecipe.Recipe' => array(
                    'fields' => array('id', 'name', 'serving_size')
                ),
                'ShoppingListIngredient.Ingredient'
            )
        );

        if ($listId == null) {
            $search = array('conditions' => array('name' => __('DEFAULT'), 
                'user_id' => $userId));
        } else {
            $search = array('conditions' => array('' . $this->primaryKey => $listId, 
                'user_id' => $userId));
        }
        
        $defaultList = $this->find('first', array_merge($options, $search));
        if (!isset($defaultList['ShoppingList']) || $defaultList['ShoppingList'] == "") {
            $newData = array(
                'id' => NULL,
                'name' => __('DEFAULT'),
                'user_id' => $userId
            );

            if ($this->save($newData)) {
                $defaultList = $this->find('first', array_merge($options, $search));
            }
        }
        // TODO: did not return new ID when call from GetDefaultListId
        return $defaultList;
    }
    
    public function isOwnedBy($listId, $user) {
        return $this->field('id', array('id' => $listId, 'user_id' => $user)) !== false;
    }
    
    /*
     * Get list of ingredients with details.  Loads the current shopping list of the logged
     *  in user.
     */
    public function getAllIngredients($listId, $userId) {
        $this->Behaviors->load('Containable');
        $search = array('conditions' => array('ShoppingList.id'=> $listId, 'ShoppingList.user_id' => $userId),
            'contain' => array( 
                'ShoppingListIngredient' => array(
                    'fields' => array('unit_id', 'quantity'),
                    'Unit' => array(
                        'fields' => array('name')
                    ),
                    'Ingredient' => array(
                        'fields' => array('name', 'location_id', 'unit_id'), 
								'Unit' => array (
								'fields' => array('name')
								)
					)
				),
                'ShoppingListRecipe' => array(
                    'fields' => array('servings'),
                    'Recipe' => array(
                        'fields' => array('name', 'serving_size'),
                        'IngredientMapping' => array(
                            'fields' => array('quantity'),
                            'Unit' => array(
                                'fields' => array('name')
                            ),
                            'Ingredient' => array(
                                'fields' => array('name', 'location_id', 'unit_id'), 
								'Unit' => array (
								'fields' => array('name')
								)
                            )
                        )
                    )
                )
   
            ));
        
        return $this->find('first', $search);
    }
    
    /*
     * Combines a list of ingredients based on type and converted if possible
     * 
     * @list - Shopping list data provided by 'getAllIngredients'
     */
    public function combineIngredients($list) {
        $ingredients = array();
        
        foreach ($list['ShoppingListIngredient'] as $item) {
            //TODO: pass on servings
            $ingredients = $this->combineIngredient($ingredients, $item, 1);
        }
        foreach ($list['ShoppingListRecipe'] as $recipeInList) {
            $recipeDetail = $recipeInList['Recipe'];
            $scaling = $recipeInList['servings'] / $recipeDetail['serving_size'];
            foreach ($recipeDetail['IngredientMapping'] as $mapping) {
                $ingredients = $this->combineIngredient($ingredients, $mapping, $scaling);
            }
        }
        
        return ($ingredients);
    }
    
    public function markIngredientsRemoved($list, $removeIds) {
        if (isset($removeIds)) {
            foreach ($removeIds as $removeId) {
                list($i, $j) = explode('-', $removeId);
                $list[$i][$j]->removed = true;
            }
        }
        return $list;
    } 
    
    /*
     * Clears all ingredients and recipes from the given shopping list.
     */
    public function clearList($userId) {
        $this->ShoppingListIngredient->deleteAll(array('ShoppingListIngredient.user_id' => $userId), false);
        $this->ShoppingListRecipe->deleteAll(array('ShoppingListRecipe.user_id' => $userId), false);
    }
    
    private function combineIngredient($list, $ingredient, $scaling) {
        $id = $ingredient['ingredient_id'];
        $unitId = $ingredient['unit_id']; 
		$targetUnitId = $ingredient['Ingredient']['unit_id']; 
	    $quantity = $ingredient['quantity'];
        $name = $ingredient['Ingredient']['name'];
        $locationId = $ingredient['Ingredient']['location_id'];
        $unitName = $ingredient['Unit']['name'];
		$targetUnitName = $ingredient['Ingredient']['Unit']['name'];
	
		$convert = array(
			'targetUnitId' => $targetUnitId, 
			'targetUnitName' => $targetUnitName, 
			'unitId' => $unitId, 
			'unitName' => $unitName, 
			'quantity' => $quantity, 
			'ingredientName' => $name
		);
	
        if (isset($list[$id])) {
            foreach ($list[$id] as $item) { 
                if ($item->unitId == $unitId) { 
                    $item->quantity += $quantity * $scaling;
				} else if ($item->id == $id) {
						$convert = $this->convertToTargetUnitAndQuantity($convert);
						$item->quantity += $convert['quantity'] * $scaling;
				} 
			}		
        } 
		else { 
            $convert = $this->convertToTargetUnitAndQuantity($convert);
			
			$this->ListItem->id = $id; 
            $this->ListItem->name = $name; 
			$this->ListItem->quantity = $convert['quantity'] * $scaling; 
			$this->ListItem->unitId = $targetUnitId;
			$this->ListItem->unitName = $targetUnitName; 
        	$this->ListItem->locationId = $locationId;
            $this->ListItem->removed = false;
            $list[$id] = array(clone $this->ListItem);
        }
        return $list;
    }
	/* 
	* Converts from the given unit to the ingredient's target unit
	*/
	private function convertToTargetUnitAndQuantity($convert) {
		
		$volume = $this->volume();
		$weight = $this->weight();
		$actionToBeTaken = (isset($volume[$convert['targetUnitId']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($weight[$convert['targetUnitId']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($volume[$convert['unitId']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($weight[$convert['unitId']])) ? 'T' : 'F';
				
		switch ($actionToBeTaken) {
			
			case "TFTF":
			$convert['quantity'] = $convert['quantity']*$volume[$convert['unitId']][$convert['targetUnitId']];
			break;
			
			//weight to volume
			case "TFFT":
			$convert = $this->correlations($convert, $volume, $weight, $actionToBeTaken);
			break;
			
			//volume to weight
			case "FTTF":
			$convert = $this->correlations($convert, $volume, $weight, $actionToBeTaken);
			break;
			
			case "FTFT":
			$convert['quantity'] = $convert['quantity']*$weight[$convert['unitId']][$convert['targetUnitId']];
			break;
			
			default:
			//doing nothing at the moment... 
			
			break;
		}
		
		return $convert;
	}
	
	
	
	private function correlations($convert, $volume, $weight, $actionToBeTaken) {
		
		$correlations = $this->correlationsArray();
		
		if (isset($correlations[$convert['ingredientName']])) {
			$units = $correlations[$convert['ingredientName']];

			//volume --> weight
			if (isset($volume[$convert['unitId']])) {
				$volumeUnit = $this->getConvertVolumeUnit($units, $volume);
				$convert['quantity'] = $convert['quantity']*$volume[$convert['unitId']][$volumeUnit];
				$weightUnit = $this->getVolumeToWeight($units, $volume);
				$convert['quantity'] = $convert['quantity']*$weightUnit['value'];
				$convert['quantity'] = $convert['quantity']*$weight[$weightUnit['weightUnit']][$convert['targetUnitId']];
			}
			//weight --> volume
			else if (isset($weight[$convert['unitId']])) {
				$weightUnit = $this->getConvertWeightUnit($units, $weight);
				$convert['quantity'] = $convert['quantity']*$weight[$convert['unitId']][$weightUnit];
				$volumeUnit = $this->getWeightToVolume($units, $weight);
				$convert['quantity'] = $convert['quantity']*$volumeUnit['value'];
				$convert['quantity'] = $convert['quantity']*$volume[$volumeUnit['volumeUnit']][$convert['targetUnitId']];
			}
		} 
		else { //the correlations between volume and weight doesn't exist.
			//assumption 1 gram = 1 millilitre
			switch($actionToBeTaken) {
				case "TFFT":
				//convert weight quantity to gram
				$convert['quantity'] = $convert['quantity']*$weight[$convert['unitId']]['21'];
				//convert gram=milliliter to target unit
				$convert['quantity'] = $convert['quantity']*$volume['23'][$convert['targetUnitId']];
				break;
				
				case "FTTF":
				//convert volume quantity to millilitre
				$convert['quantity'] = $convert['quantity']*$volume[$convert['unitId']]['23'];
				//convert milliliter=gram to target unit
				$convert['quantity'] = $convert['quantity']*$weight['21'][$convert['targetUnitId']];
				break;
				
				default:
				break;
			}
		}
		return $convert;
	}
	
	private function getConvertWeightUnit($units, $weight) {
		
		$weightUnit;
		
		if (isset($weight[key($units)])) {
			$weightUnit = key($units);
		} 
		else {
			next($units);
			$weightUnit = key($units);
		}		
		return $weightUnit;
	}
	
	private function getConvertVolumeUnit($units, $volume) {
		
		$volumeUnit;
		
		if (isset($volume[key($units)])) {
			$volumeUnit = key($units);
		} 
		else {
			next($units);
			$volumeUnit = key($units);
		}
		
		return $volumeUnit;
			
	}
	
	private function getVolumeToWeight($units, $volume) {
		
		$weightUnit = array('value', 
							'weightUnit'
						);
		
		if (isset($volume[key($units)])) {
			$weightUnit['value'] = $units[key($units)];
			next($units);
			$weightUnit['value'] = $units[key($units)]/$weightUnit['value'];
			$weightUnit['weightUnit'] = key($units);
		}
		else {
			next($units);
			$weightUnit['value'] = $units[key($units)];
			prev($units);
			$weightUnit['value'] = $units[key($units)]/$weightUnit['value'];
			$weightUnit['weightUnit'] = key($units);
		}
		
		return $weightUnit;
	}
	
	private function getWeightToVolume($units, $weight) {
		
		$voluemUnit = array('value', 
							'volumeUnit'
						);
		
		if (isset($weight[key($units)])) {
			$volumeUnit['value'] = $units[key($units)];
			next($units);
			$volumeUnit['value'] = $units[key($units)]/$volumeUnit['value'];
			$volumeUnit['volumeUnit'] = key($units);
		}
		else {
			next($units);
			$volumeUnit['value'] = $units[key($units)];
			prev($units);
			$volumeUnit['value'] = $units[key($units)]/$volumeUnit['value'];
			$volumeUnit['volumeUnit'] = key($units);
		}
		
		return $volumeUnit;
	}
	/*
	* returns the array of correlations
	*/
	private function correlationsArray() {
		$correlations = array (
			'vetemjöl' => array (
				'21' => 60,
				'26' => 1 
			), 
			'strösocker' => array (
				'26' => 1,
				'21' => 85
			),
			'bacon' => array (
				'26' => 1,
				'21' => 34
			), 
			'bakpulver' => array (
				'26' => 1,
				'21' => 5
			), 
			'basmat ris' => array (
				'26' => 1,
				'21' => 85
			), 
			'pasta' => array (
				'26' => 8,
				'21' => 280
			)
			
		);
		
		return $correlations;
	}
	
	/*	
	* Returns the matrix related to volumes. 
	*/
	private function volume() {		
		$milliliter_tbsp = 1/15;
		$tesked_tbsp = 5/15;
		$centiliter_tbsp = 10/15;
		$dl_tbps = 100/15; 
		$liter_tbsp = 1000/15;
		
		//29 = kryddmått
		//23 = milliliter
		//28 = teaspoon_m
		//24 = centiliter
		//27 = tablespoon_m 
		//26 = deciliter
		//25 = liter
		$volumes = array(
			'29' => array(
				'29' => 1, 
				'23' => 1,
				'28' => 0.2,
				'24' => 0.1, 
				'27' => $milliliter_tbsp, 
				'26' => 0.01, 
				'25' => 0.001
				), 
			'23' => array(
				'29' => 1, 
				'23' => 1,
				'28' => 0.2,
				'24' => 0.1, 
				'27' => $milliliter_tbsp, 
				'26' => 0.01, 
				'25' => 0.001
				), 
			'28' => array(
				'29' => 5, 
				'23' => 5,
				'28' => 1,
				'24' => 0.5, 
				'27' => $tesked_tbsp, 
				'26' => 0.05, 
				'25' => 0.005
				), 
			'24' => array(
				'29' => 10, 
				'23' => 10,
				'28' => 2,
				'24' => 1, 
				'27' => $centiliter_tbsp, 
				'26' => 0.1, 
				'25' => 0.01
				), 
			'27' => array(
				'29' => 15,
				'23' => 15,
				'28' => 3,
				'24' => 1.5,
				'27' => 1, 
				'26' => 0.15, 
				'25' => 0.015
				), 
			'26' => array(
				'29' => 100,
				'23' => 100,
				'28' => 20,
				'24' => 10, 
				'27' => $dl_tbps, 
				'26' => 1, 
				'25' => 0.1
				), 
			'25' => array(
				'29' => 1000,
				'23' => 1000,
				'28' => 200, 
				'24' => 100, 
				'27' => $liter_tbsp, 
				'26' => 10, 
				'25' => 1
				)
			);
		return $volumes;
	}
	
	private function weight() {
		
		//21 = gram
		//35 = hektogram
		//22 = kilogram
		$weights = array(
			'21' => array(
				'21' => 1, 
				'35' => 0.01, 
				'22' => 0.001
			), 
			'35' => array(
				'21' => 100, 
				'35' => 1, 
				'22' => 0.1
			), 
			'22' => array(
				'21' => 1000, 
				'35' => 10, 
				'22' => 1
			)
		);
		return $weights; 
	}
	
}
