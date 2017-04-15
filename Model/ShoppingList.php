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
		$actionToBeTaken = (isset($volume[$convert['targetUnitName']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($weight[$convert['targetUnitName']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($volume[$convert['unitName']])) ? 'T' : 'F';
		$actionToBeTaken .= (isset($weight[$convert['unitName']])) ? 'T' : 'F';
				
		switch ($actionToBeTaken) {
			
			case "TFTF":
			$convert['quantity'] = $convert['quantity']*$volume[$convert['unitName']][$convert['targetUnitName']];
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
			$convert['quantity'] = $convert['quantity']*$weight[$convert['unitName']][$convert['targetUnitName']];
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
			if (isset($volume[$convert['unitName']])) {
				$volumeUnit = $this->getConvertVolumeUnit($units, $volume);
				$convert['quantity'] = $convert['quantity']*$volume[$convert['unitName']][$volumeUnit];
				$weightUnit = $this->getVolumeToWeight($units, $volume);
				$convert['quantity'] = $convert['quantity']*$weightUnit['value'];
				$convert['quantity'] = $convert['quantity']*$weight[$weightUnit['weightUnit']][$convert['targetUnitName']];
			}
			//weight --> volume
			else if (isset($weight[$convert['unitName']])) {
				$weightUnit = $this->getConvertWeightUnit($units, $weight);
				$convert['quantity'] = $convert['quantity']*$weight[$convert['unitName']][$weightUnit];
				$volumeUnit = $this->getWeightToVolume($units, $weight);
				$convert['quantity'] = $convert['quantity']*$volumeUnit['value'];
				$convert['quantity'] = $convert['quantity']*$volume[$volumeUnit['volumeUnit']][$convert['targetUnitName']];
			}
		} 
		else { //the correlations between volume and weight doesn't exist.
			//assumption 1 gram = 1 millilitre
			switch($actionToBeTaken) {
				case "TFFT":
				//convert weight quantity to gram
				$convert['quantity'] = $convert['quantity']*$weight[$convert['unitName']]['gram'];
				//convert gram=milliliter to target unit
				$convert['quantity'] = $convert['quantity']*$volume['milliliter'][$convert['targetUnitName']];
				break;
				
				case "FTTF":
				//convert volume quantity to millilitre
				$convert['quantity'] = $convert['quantity']*$volume[$convert['unitName']]['milliliter'];
				//convert milliliter=gram to target unit
				$convert['quantity'] = $convert['quantity']*$weight['gram'][$convert['targetUnitName']];
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
				'gram' => 60,
				'deciliter' => 1 
			), 
			'strösocker' => array (
				'deciliter' => 1,
				'gram' => 85
			),
			'bacon' => array (
				'deciliter' => 1,
				'gram' => 34
			), 
			'bakpulver' => array (
				'deciliter' => 1,
				'gram' => 5
			), 
			'basmat ris' => array (
				'deciliter' => 1,
				'gram' => 85
			), 
			'pasta' => array (
				'deciliter' => 8,
				'gram' => 280
			)
			
		);
		
		return $correlations;
	}
	
	/*	
	* Returns the matrix related to volumes. 
	*/
	private function volume() {		
		$millilitre_msk = 1/15;
		$tesked_msk = 5/15;
		$centilitre_msk = 10/15;
		$dl_msk = 100/15; 
		$litre_msk = 1000/15;
		
		
		$volumes = array(
			'kryddmått' => array(
				'kryddmått' => 1, 
				'milliliter' => 1,
				'tesked' => 0.2,
				'centiliter' => 0.1, 
				'matsked' => $millilitre_msk, 
				'deciliter' => 0.01, 
				'liter' => 0.001
				), 
			'milliliter' => array(
				'kryddmått' => 1, 
				'milliliter' => 1,
				'tesked' => 0.2,
				'centiliter' => 0.1, 
				'matsked' => $millilitre_msk, 
				'deciliter' => 0.01, 
				'liter' => 0.001
				), 
			'tesked' => array(
				'kryddmått' => 5, 
				'milliliter' => 5,
				'tesked' => 1,
				'centiliter' => 0.5, 
				'matsked' => $tesked_msk, 
				'deciliter' => 0.05, 
				'liter' => 0.005
				), 
			'centiliter' => array(
				'kryddmått' => 10, 
				'milliliter' => 10,
				'tesked' => 2,
				'centiliter' => 1, 
				'matsked' => $centilitre_msk, 
				'deciliter' => 0.1, 
				'liter' => 0.01
				), 
			'matsked' => array(
				'kryddmått' => 15,
				'milliliter' => 15,
				'tesked' => 3,
				'centiliter' => 1.5,
				'matsked' => 1, 
				'deciliter' => 0.15, 
				'liter' => 0.015
				), 
			'deciliter' => array(
				'kryddmått' => 100,
				'milliliter' => 100,
				'tesked' => 20,
				'centiliter' => 10, 
				'matsked' => $dl_msk, 
				'deciliter' => 1, 
				'liter' => 0.1
				), 
			'liter' => array(
				'kryddmått' => 1000,
				'milliliter' => 1000,
				'tesked' => 200, 
				'centiliter' => 100, 
				'matsked' => $litre_msk, 
				'deciliter' => 10, 
				'liter' => 1
				)
			);
		return $volumes;
	}
	
	private function weight() {
		$weights = array(
			'gram' => array(
				'gram' => 1, 
				'hekto' => 0.01, 
				'kilogram' => 0.001
			), 
			'hekto' => array(
				'gram' => 100, 
				'hekto' => 1, 
				'kilogram' => 0.1
			), 
			'kilogram' => array(
				'gram' => 1000, 
				'hekto' => 10, 
				'kilogram' => 1
			)
		);
		return $weights; 
	}
	
}
