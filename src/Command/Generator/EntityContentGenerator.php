<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/06/15
 * Time: 22:19
 */

namespace portfolio\Command\Generator;


class EntityContentGenerator extends AbstractGenerator {

    /**
     * @return string
     */
    public function getRoot(){

        return __DIR__ . '/../../Entity/Generated/';
    }

    /**
     * @param null $table
     *
     * @return string
     */
    public function getTitleFile($table = null){

        return $this->getTitleToCamelCase($table['title']);
    }

    /**
     * @param $column
     *
     * @return array
     */
    private function getConstraintsByColumn($column){
        $constraint = array();
        $constraint['title'] = lcfirst($this->getTitleToCamelCase($column['title']));
        $replace = array('(', ')');
        $data = str_replace($replace, ' ', $column['Type']);
        $dataArray = explode(' ', $data);

        $constraint['type'] = $dataArray[0];

        $constraint['type'] = str_replace('varchar', 'string', $constraint['type']);
        $constraint['type'] = str_replace('datetime', '\DateTime', $constraint['type']);

        if(array_key_exists(1, $dataArray)){
            $constraint['limit'] = $dataArray[1];
        }
        $constraint['null'] = ($column['Null'] == 'YES' ?  true :  false);;
        $constraint['key'] = ($column['Key'] == 'PRI' ?  true : false);
        if(array_key_exists('Constraint', $column)){
            $constraint['relation'] = ($column['Key'] == 'MUL' ?  'Many To Many' : 'Many To One');
            $constraint['table_target'] = $column['Constraint']['referenced_table_name'];
            $constraint['column_target'] = $column['Constraint']['referenced_column_name'];
        }

        return $constraint;
    }

    /**
     * @param $constraint
     *
     * @return array
     */
    private function getAssert($constraint){

        $assert = array();

        if(array_key_exists('limit', $constraint)){
            $assert[] = '$metadata->addPropertyConstraint("'.$constraint['title'] .'", new Assert\Length(array("max" => '. $constraint['limit'].', "maxMessage" => "trop long")));';
        }
        if(array_key_exists('null', $constraint) && $constraint['null'] === false ){
            $assert[] = '$metadata->addPropertyConstraint("'.$constraint['title'] .'", new Assert\NotBlank(array("message" => "Not null")));';
        }

        return $assert;
    }

    /**
     * @param $table
     *
     * @return string
     */
    public function getContentEntityFile($table)
    {
        $dateTime = false;

        $content ='<?php'."\n";
        $content .= $this->getStartEntityCommentFile($table['title']);
        // add namespace
        $content .= 'namespace portfolio\Entity\Generated;'."\n"."\n";
        // add assert
        $content .= 'use Symfony\Component\Validator\Mapping\ClassMetadata;'."\n";
        $content .= 'use Symfony\Component\Validator\Constraints as Assert;'."\n"."\n"."\n";
        //add start class
        $content .= 'class '. $this->getTitleToCamelCase($table['title']).' implements Entity'."\n";
        $content .= '{'."\n";
        // add Var
        foreach($table['columns'] as $var){
            $constraints = $this->getConstraintsByColumn($var);
            if($constraints['type'] === '\DateTime'){
                $dateTime = true;
            }
            $content .= "\n".'   /**'."\n";
            $content .= ($constraints['key'] === true ? '    * Primary key'."\n".'    *'."\n" : null);
            $content .= (array_key_exists('relation', $constraints) ? '    * Relation '.$constraints['relation']."\n" : null);
            $content .= (array_key_exists('table_target', $constraints) ? '    * Table-target '.$constraints['table_target'].' '. $constraints['column_target'] ."\n".'    *'."\n" : null);
            $content .= '    * @var '. $constraints['type'] ."\n";
            $content .= '    */' ."\n";
            $content .= '   protected $'.lcfirst($this->getTitleToCamelCase($var['title'])) .' = null;' ."\n";
        }
        // add construct Datetime
        if($dateTime === true){
            $content .= "\n".'   /**'."\n";
            $content .= '    * set default var \Datetime ' ."\n";
            $content .= '    */' ."\n";
            $content .= '   function __construct()' ."\n";
            $content .= '   {' ."\n";
            foreach($table['columns'] as $var){
                $constraints = $this->getConstraintsByColumn($var);
                if($constraints['type'] == '\DateTime'){
                    $content .= '       $this->'.lcfirst($this->getTitleToCamelCase($var['title'])) .' = new \DateTime("now");' ."\n";
                }
            }
            $content .= '   }' ."\n";
        }
        //TODO CONDITIONNER LES CREATIONS D'ASSERT
        // add Assert Constraint
        $content .= "\n".'   /**'."\n";
        $content .= '    * @param ClassMetadata $metadata'."\n";
        $content .= '    */' ."\n";
        $content .= '   static public function loadValidatorMetadata(ClassMetadata $metadata)' ."\n";
        $content .= '   {'."\n";
        foreach($table['columns'] as $var) {
            $asserts = $this->getAssert($this->getConstraintsByColumn($var));
            foreach($asserts as $assert){
                $content .='       '.$assert."\n";
            }
        }
        $content .= '   }' ."\n";
        //add getter Setter
        foreach($table['columns'] as $var){
            $constraints = $this->getConstraintsByColumn($var);
            // add getter
            $content .= "\n".'   /**'."\n";
            $content .= '    * @return '.$constraints['type']."\n";
            $content .= '    */' ."\n";
            $content .= '   public function get'.$this->getTitleToCamelCase($var['title']).'()'."\n";
            $content .= '   {'."\n";
            $content .= '       return $this->'.lcfirst($this->getTitleToCamelCase($var['title'])).';'."\n";
            $content .= '   }'."\n";
            //add setter
            $content .= "\n".'   /**'."\n";
            $content .= '    * @param '.$constraints['type'].' $'.lcfirst($this->getTitleToCamelCase($var['title']))."\n";
            $content .= '    */' ."\n";
            $content .= '   public function set'.$this->getTitleToCamelCase($var['title']).'($'.lcfirst($this->getTitleToCamelCase($var['title'])).')'."\n";
            $content .= '   {'."\n"; // if param is string to dateTime add converter
                if($constraints["type"] == "\DateTime"){
                    $content .= '       if($'.lcfirst($this->getTitleToCamelCase($var['title'])).' instanceof \\DateTime){'."\n";
                    $content .= '           $this->'.lcfirst($this->getTitleToCamelCase($var['title'])).' = $'.lcfirst($this->getTitleToCamelCase($var['title'])).';'."\n";
                    $content .= '       } else {'."\n";
                }
                // add indentation if datetime append
            $content .= '       '.($constraints["type"] == "\DateTime" ? '    ' : null).'$this->'.lcfirst($this->getTitleToCamelCase($var['title'])).' = '.($constraints["type"] == "\DateTime" ? "date_create_from_format('Y-m-d H:i:s', $".lcfirst($this->getTitleToCamelCase($var['title'])) .")" : "$".lcfirst($this->getTitleToCamelCase($var['title']))).';'."\n";
            if($constraints["type"] == "\DateTime"){
              $content .= '       }'."\n";
            }
            $content .= '   }'."\n";
        }

        //add toArray for Entity interface
        $content .= "\n".'   /**'."\n";
        $content .= '    * @return array Entity '."\n";
        $content .= '    */' ."\n";
        $content .= '   public function toArray()'."\n";
        $content .= '   {'."\n";
        $content .= '       $entity = array('."\n";
        foreach($table['columns'] as $var){
            $content .='            "'.$var['title'].'" => $this->'.lcfirst($this->getTitleToCamelCase($var['title'])).','."\n";
        }
        $content .= '       );'."\n";
        //add string converter \datetime
        foreach($table['columns'] as $var){
            $constraints = $this->getConstraintsByColumn($var);
            if($constraints['type'] == '\DateTime'){
                $content .= '       if($this->'.lcfirst($this->getTitleToCamelCase($var['title'])) .' instanceof \DateTime){' ."\n";
                $content .= '           $entity["'.$var['title'] .'"] = date_format($this->'.lcfirst($this->getTitleToCamelCase($var['title'])) .', "Y-m-d H:i:s");'."\n";
                $content .= '       }'."\n";
            }
        }
        $content .= '       return $entity;'."\n";
        $content .= '   }'."\n";

        // Close Entity file
        $content .= "\n".'}'."\n";

        return $content;
    }

    /**
     * CREATE INTERFACE ENTITY
     *
     * @return string
     */
    public function getContentInterfaceEntityFile()
    {
        // start file.php
        $content = '<?php'."\n";
        $content .= $this->getStartEntityCommentFile();
        $content .= 'namespace portfolio\Entity\Generated;'."\n\n\n";
        $content .= 'interface Entity {'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @return array'."\n";
        $content .= '     */'."\n";
        $content .= '    public function toArray();'."\n";

        // Close Entity file
        $content .= "\n".'}';


        return $content;
    }

    /**
     * @param string $title
     *
     * @return string
     */
    private function getStartEntityCommentFile($title = 'Interface'){

        $date = new \DateTime('now');
        $comment = '';
        $comment .='/**'."\n";
        $comment .=' * Entity '.$this->getTitleToCamelCase($title)."\n";
        $comment .=' * Auto Generate :'.date_format($date, "Y-m-d H:i:s")."\n";
        $comment .=' * '.$title."\n";
        $comment .=' */'."\n";

        return $comment;
    }

}