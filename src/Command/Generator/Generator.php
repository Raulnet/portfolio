<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/06/15
 * Time: 22:18
 */

namespace portfolio\Command\Generator;

use PDO;

class Generator {

    /**
     * @var PDO
     */
    private $bdd;

    /**
     * @var array
     */
    private $tables;

    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=127.0.0.1;dbname=rolnet800957;charset=utf8', 'Raulnet', '');
        $this->tables = $this->getAllTables();

    }

    /**
     * @return bool
     */
    public function generate(){
        $files = array();
        // ========== Generate Entities =========
        $entities = new EntityContentGenerator();
        // Create Folder
        if (!file_exists($entities->getRoot())) {
            mkdir($entities->getRoot(), 0777, true);
        }
        // Add Entity Interface
        $files[] = $this->saveFileInterfaceEntity($entities->getRoot(), $entities);
        //Generate entities files
        foreach ($this->tables as $table) {
            $files[] = $this->saveFileEntity($entities, $table);
        }
        // ======================================

        // ======= Generate EntitiesZEM =========
        $entitiesZEM = new EntityZEMContentGenerator();
        if (!file_exists($entitiesZEM->getRoot())) {
            mkdir($entitiesZEM->getRoot(), 0777, true);
        }
        // Add DAO Abstract
        $files[] = $this->saveFileAbstractZEM($entitiesZEM->getRoot(), $entitiesZEM);
        // Generate EntitiesZEM Fiels
        foreach ($this->tables as $table) {
            $files[] = $this->saveFileZEM($entitiesZEM, $table);
        }
        // ======================================

        return $files;
    }

    /**
     * @param $rootFolder
     * @param EntityContentGenerator $entities
     *
     * @return bool
     */
    private function saveFileInterfaceEntity($rootFolder, EntityContentGenerator $entities)
    {
        $file = fopen($rootFolder.'Entity.php', 'w+');
        fputs($file, $entities->getContentInterfaceEntityFile());
        fclose($file);

        return 'Entity.php';
    }

    /**
     * @param $rootFolder
     * @param EntityZEMContentGenerator $entitiesZEM
     *
     * @return bool
     */
    private function saveFileAbstractZEM($rootFolder, $entitiesZEM)
    {
        $file = fopen($rootFolder.'ZEM.php', 'w+');
        fputs($file, $entitiesZEM->getContentZEMAbstractFile());
        fclose($file);

        return 'ZEM.php';
    }

    /**
     * @param EntityContentGenerator $entities
     * @param $table
     *
     * @return bool
     */
    private function saveFileEntity($entities, $table)
    {
        $file = fopen($entities->getRoot() . $entities->getTitleFile($table) . '.php', 'w+');
        fputs($file, $entities->getContentEntityFile($table));
        fclose($file);

        return $entities->getTitleFile($table) . '.php';
    }

    /**
     * @param EntityZEMContentGenerator  $entitiesZEM
     * @param $table
     *
     * @return bool
     */
    private function saveFileZEM($entitiesZEM, $table)
    {
        $title = $entitiesZEM->getTitleFile($table);
        $file = fopen($entitiesZEM->getRoot() . $title . 'ZEM.php', 'w+');
        fputs($file, $entitiesZEM->getContentZEMFile($table));
        fclose($file);

        return $title . 'ZEM.php';
    }


    /**
     * @return array $tables
     */
    private function getAllTables(){

        $tables  = $this->bdd->query('SHOW TABLES FROM rolnet800957');
        $schemas = array();
        foreach ($tables as $table) {
            $schemas[$table['Tables_in_rolnet800957']] = array('title' => $table['Tables_in_rolnet800957']);
        }
        $schema = array();
        foreach ($schemas as $table) {
            $title       = $table['title'];
            $constraints = $this->getConstraint($title);
            $columns = $this->bdd->query("SHOW COLUMNS FROM " . $title . "");
            $column  = array();
            if ($columns) {
                foreach ($columns as $data) {
                    $column[$data['Field']] = array(
                        'title'   => $data['Field'],
                        'Type'    => $data['Type'],
                        'Null'    => $data['Null'],
                        'Key'     => $data['Key'],
                        'Default' => $data['Default'],
                        'Extra'   => $data['Extra']
                    );
                    if (array_key_exists($data['Field'], $constraints)) {
                        $column[$data['Field']]['Constraint'] = $constraints[$data['Field']];
                    }
                }
                $schema[$title] = array(
                    'title'   => $title,
                    'columns' => $column
                );
            }
        }
        return $schema;
    }

    /**
     * @param $table
     *
     * @return array
     */
    private function getConstraint($table)
    {
        $cons        = $this->bdd->query('select *
                              from information_schema.table_constraints
                              where table_schema = schema()
                              and table_name = "' . $table . '"');
        $constraints = array();
        foreach ($cons as $row) {
            {
                $constraintName = $row['CONSTRAINT_NAME'];
                if ($constraintName !== 'PRIMARY') {
                    $constraint = $this->bdd->query("select * from information_schema.key_column_usage
                                                where  table_schema = schema()
                                                and table_name = '" . $table . "'
                                                and constraint_name = '" . $constraintName . "'");
                    $data                              = $constraint->fetch();
                    $constraints[$data['COLUMN_NAME']] = array(
                        "column_name"            => $data['COLUMN_NAME'],
                        "referenced_table_name"  => $data['REFERENCED_TABLE_NAME'],
                        "referenced_column_name" => $data['REFERENCED_COLUMN_NAME'],
                    );
                }

            }
        }

        return $constraints;
    }

}