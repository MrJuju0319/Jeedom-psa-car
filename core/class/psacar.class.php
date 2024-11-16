<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class psacar extends eqLogic {
  /*     * *************************Attributs****************************** */

  /*
  * Permet de définir les possibilités de personnalisation du widget (en cas d'utilisation de la fonction 'toHtml' par exemple)
  * Tableau multidimensionnel - exemple: array('custom' => true, 'custom::layout' => false)
  public static $_widgetPossibility = array();
  */

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration du plugin
  * Exemple : "param1" & "param2" seront cryptés mais pas "param3"
  public static $_encryptConfigKey = array('param1', 'param2');
  */

  /*     * ***********************Methode static*************************** */

  /*
  * Fonction exécutée automatiquement toutes les minutes par Jeedom
  public static function cron() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 5 minutes par Jeedom
  public static function cron5() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 10 minutes par Jeedom
  public static function cron10() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 15 minutes par Jeedom
  public static function cron15() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les 30 minutes par Jeedom
  public static function cron30() {}
  */

  /*
  * Fonction exécutée automatiquement toutes les heures par Jeedom
  public static function cronHourly() {}
  */

  /*
  * Fonction exécutée automatiquement tous les jours par Jeedom
  public static function cronDaily() {}
  */
  
  /*
  * Permet de déclencher une action avant modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function preConfig_param3( $value ) {
    // do some checks or modify on $value
    return $value;
  }
  */

  /*
  * Permet de déclencher une action après modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function postConfig_param3($value) {
    // no return value
  }
  */

  /*
   * Permet d'indiquer des éléments supplémentaires à remonter dans les informations de configuration
   * lors de la création semi-automatique d'un post sur le forum community
   public static function getConfigForCommunity() {
      // Cette function doit retourner des infos complémentataires sous la forme d'un
      // string contenant les infos formatées en HTML.
      return "les infos essentiel de mon plugin";
   }
   */

  /*     * *********************Méthodes d'instance************************* */

  // Fonction exécutée automatiquement avant la création de l'équipement
  public function preInsert() {
  }

  // Fonction exécutée automatiquement après la création de l'équipement
  public function postInsert() {
  }

  // Fonction exécutée automatiquement avant la mise à jour de l'équipement
  public function preUpdate() {
  }

  // Fonction exécutée automatiquement après la mise à jour de l'équipement
  public function postUpdate() {
  }

  // Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement
  public function preSave() {
  }

  // Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement
  public function postSave() {
    // INFORMATIONS
    	$info = $this->getCmd(null, 'carstate');
		if (!is_object($info)) {
			$info = new psacarCmd();
			$info->setName(__('Etat du véhicule', __FILE__));
		}
		$info->setOrder(1);
		$info->setLogicalId('carstate');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsVisible(1);
		$info->setIsHistorized(0);
		$info->save();
    
    	$info = $this->getCmd(null, 'getconfig');
		if (!is_object($info)) {
			$info = new psacarCmd();
			$info->setName(__('Récupérer la configuration', __FILE__));
		}
		$info->setOrder(1);
		$info->setLogicalId('getconfig');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsVisible(1);
		$info->setIsHistorized(0);
		$info->save();
    
		$info = $this->getCmd(null, 'getbatterysoh');
		if (!is_object($info)) {
			$info = new psacarCmd();
			$info->setName(__("Charge de la batterie", __FILE__));
		}
		$info->setOrder(3);
		$info->setLogicalId('getbatterysoh');
		$info->setEqLogic_id($this->getId());
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsVisible(1);
		$info->setIsHistorized(1);
    	$info->setUnite("%");
		$info->setDisplay('forceReturnLineAfter', true);
		$info->setConfiguration("historyPurge", "-3 month");
		$info->save();

    
    // ACTIONS
        $newCmd = $this->getCmd(null, "stopcharge");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Stopper la charge", __FILE__));
        }
        $newCmd->setLogicalId("stopcharge");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->setGeneric_type("ENERGY_OFF");
    	$newCmd->save();

        $newCmd = $this->getCmd(null, "updatechargehour");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Heure de début de charge", __FILE__));
        }
        $newCmd->setLogicalId("updatechargehour");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("message");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->setGeneric_type("ENERGY_ON");
    	$newCmd->save();
    
        $newCmd = $this->getCmd(null, "chargecontrolhour");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Heure de fin de charge", __FILE__));
        }
        $newCmd->setLogicalId("chargecontrolhour");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("message");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->setGeneric_type("ENERGY_OFF");
    	$newCmd->save();

        $newCmd = $this->getCmd(null, "chargecontrolpercent");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Pourcentage de fin de charge", __FILE__));
        }
        $newCmd->setLogicalId("chargecontrolpercent");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("message");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->setGeneric_type("ENERGY_OFF");
    	$newCmd->save();
    
        $newCmd = $this->getCmd(null, "refreshstate");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Actualiser l'état", __FILE__));
        }
        $newCmd->setLogicalId("refreshstate");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("message");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();

           
    	$newCmd = $this->getCmd(null, "preconditioning_on");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Activer le préconditionnement", __FILE__));
        }
        $newCmd->setLogicalId("preconditioning_on");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
    
    	$newCmd = $this->getCmd(null, "preconditioning_off");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Désactiver le préconditionnement", __FILE__));
        }
        $newCmd->setLogicalId("preconditioning_off");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
    
    	$newCmd = $this->getCmd(null, "honk_horn");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Klaxonner", __FILE__));
        }
        $newCmd->setLogicalId("honk_horn");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
    
    	$newCmd = $this->getCmd(null, "flash_lights");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Appels de phares", __FILE__));
        }
        $newCmd->setLogicalId("flash_lights");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
    
    	$newCmd = $this->getCmd(null, "lock");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Fermer les ports", __FILE__));
        }
        $newCmd->setLogicalId("lock");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
    
    	$newCmd = $this->getCmd(null, "unlock");
        if (!is_object($newCmd)) {
            $newCmd = new psacarCmd();
            $newCmd->setName(__("Ouvrir les portes", __FILE__));
        }
        $newCmd->setLogicalId("unlock");
        $newCmd->setEqLogic_id($this->getId());
        $newCmd->setType("action");
        $newCmd->setSubType("other");
        $newCmd->setOrder(1);
        $newCmd->setIsVisible(1);
        $newCmd->setIsHistorized(0);
    	$newCmd->save();
  }

  // Fonction exécutée automatiquement avant la suppression de l'équipement
  public function preRemove() {
  }

  // Fonction exécutée automatiquement après la suppression de l'équipement
  public function postRemove() {
  }

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration des équipements
  * Exemple avec le champ "Mot de passe" (password)
  public function decrypt() {
    $this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
  }
  public function encrypt() {
    $this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
  }
  */

  /*
  * Permet de modifier l'affichage du widget (également utilisable par les commandes)
  public function toHtml($_version = 'dashboard') {}
  */

  /*     * **********************Getteur Setteur*************************** */
}

class psacarCmd extends cmd {
  /*     * *************************Attributs****************************** */

  /*
  public static $_widgetPossibility = array();
  */

  /*     * ***********************Methode static*************************** */


  /*     * *********************Methode d'instance************************* */

  /*
  * Permet d'empêcher la suppression des commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
  public function dontRemoveCmd() {
    return true;
  }
  */

  // Exécution d'une commande
  public function execute($_options = array()) {
    
    	$eqLogic = $this->getEqLogic(); // Récupération de l’eqlogic

		switch ($this->getLogicalId()) {
          case 'stopcharge':
            //http://localhost:5000/charge_now/YOURVIN/0
          break;
          case 'updatechargehour':
            //http://localhost:5000/charge_hour?vin=YOURVIN&hour=22&minute=30
          break;
          case 'chargecontrolhour':
            //http://localhost:5000/charge_control?vin=YOURVIN&hour=6&minute=0
          break;
          case 'chargecontrolpercent':
            //http://localhost:5000/charge_control?vin=YOURVIN&percentage=80
          break;
          case 'refreshstate':
            //http://localhost:5000/get_vehicleinfo/YOURVIN
            //http://localhost:5000/get_vehicleinfo/YOURVIN?from_cache=1
            //Refresh car state (ask car to send its state): http://localhost:5000/wakeup/YOURVIN
            // prendre en compte un paramètre cache/force update
          break;
          case 'preconditioning_on':
            // http://localhost:5000/preconditioning/YOURVIN/1
          break;
          case 'preconditioning_off':
            //http://localhost:5000/preconditioning/YOURVIN/0
          break;
          case 'honk_horn':
            //http://localhost:5000/horn/YOURVIN/count (verif < 10)
          break;
          case 'flash_lights':
            //http://localhost:5000/lights/YOURVIN/duration (duration n'aurait pas trop deffet sur la durée
          break;
          case 'lock':
            //http://localhost:5000/lock_door/YOURVIN/1
          break;
          case 'unlock':
            //http://localhost:5000/lock_door/YOURVIN/0
          break;

          default:
          throw new Error('This should not append!');
          log::add('psacar', 'warn', 'Error while executing cmd ' . $this->getLogicalId());
          break;
		}
		
		
		return;
    
  }

  /*     * **********************Getteur Setteur*************************** */
}