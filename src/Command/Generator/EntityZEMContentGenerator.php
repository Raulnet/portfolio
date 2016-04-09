<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/06/15
 * Time: 22:20
 */

namespace portfolio\Command\Generator;


class EntityZEMContentGenerator extends AbstractGenerator{

    /**
     * @return string
     */
    public function getRoot(){

        return __DIR__ . '/../../ZEM/Generated/';
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
     * @param string $title
     *
     * @return string
     */
    private function getStartZemCommentFile($title = 'Interface'){

        $date = new \DateTime('now');
        $comment = '';
        $comment .='/**'."\n";
        $comment .=' * Zend Entity Manager ZEM '.$this->getTitleToCamelCase($title)."\n";
        $comment .=' * Auto Generate :'.date_format($date, "Y-m-d H:i:s")."\n";
        $comment .=' * '.$title."\n";
        $comment .=' */'."\n";

        return $comment;
    }

    public function getContentZEMFile($table){
        // start file.php
        $content = '';
        $content .= '<?php'."\n";
        $content .= $this->getStartZemCommentFile($table['title']);
        $content .= 'namespace portfolio\ZEM\Generated;'."\n\n";
        $content .= 'use portfolio\Entity\Generated\\'.$this->getTitleToCamelCase($table['title']).';'."\n\n";
        $content .= 'class '.$this->getTitleToCamelCase($table['title']).'ZEM extends ZEM {'."\n\n";
        // Add var Table
        $content .= '    /**'."\n";
        $content .= '     * @var string table Entity'."\n";
        $content .= '     */'."\n";
        $content .= '    protected $table = "'.$table['title'].'";'."\n\n";
        // Add var Primary Key
        $iPos = 0;
        $primaryKey = array('$primaryKey', '$secondaryKey');
        foreach($table['columns'] as $var){
            if($var['Key'] === 'PRI' && $iPos < 2){
                $content .= '    /**'."\n";
                $content .= '     * @var string '.$primaryKey[$iPos]."\n";
                $content .= '     */'."\n";
                $content .= '    protected '.$primaryKey[$iPos].' = "'.$var['title'].'";'."\n\n";
                $iPos++;
            }
        }
        // Add construct
        $content .= '    /**'."\n";
        $content .= '     * @param $configArray'."\n";
        $content .= '     * @param Application $app'."\n";
        $content .= '     */'."\n";
        $content .= '    function __construct($configArray, $app)'."\n";
        $content .= '    {'."\n";
        $content .= '        parent::__construct($configArray, $app);'."\n";
        $content .= '    }'."\n\n";
        // Add Build Entity Object
        $content .= '    /**'."\n";
        $content .= '     * @param $row'."\n";
        $content .= '     * @return '.$this->getTitleToCamelCase($table['title'])."\n";
        $content .= '     */'."\n";
        $content .= '    protected function buildZEntityObject($row)'."\n";
        $content .= '    {'."\n";
        $content .= '        $entity = new '. $this->getTitleToCamelCase($table['title']).'();'."\n";
        foreach($table['columns'] as $var){
            $content .= '        $entity->set'.$this->getTitleToCamelCase($var['title']).'($row["'.$var['title'].'"]);'."\n";
        }
        $content .= '        return $entity;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @param int        $id primaryKey'."\n";
        $content .= '     * @param null|int   $id2 secondaryKey'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return '.$this->getTitleToCamelCase($table['title'])."\n";
        $content .= '     */'."\n";
        $content .= '    public function findOneById($id'.($iPos > 1 ? ', $id2' : ', $id2 = null').'){'."\n\n";
        $content .= '        return $this->findOneEntityById($id'.($iPos > 1 ? ', $id2' : ', $id2 = null').');'."\n";
        $content .= '    }'."\n";

        // Close Entity file
        $content .= "\n".'}';
        return $content;
    }

    public function getContentZEMAbstractFile(){
        // start file.php
        $content = '';
        $content .= '<?php'."\n";
        $content .= $this->getStartZemCommentFile('Abstract');
        $content .= 'namespace portfolio\ZEM\Generated;'."\n\n";
        $content .= 'use Zend\Db\TableGateway\AbstractTableGateway;'."\n";
        $content .= 'use Zend\Db\Sql\Sql;'."\n";
        $content .= 'use Zend\Db\Adapter\Adapter;'."\n";
        $content .= 'use portfolio\Entity\Generated\Entity;'."\n\n";
        $content .= 'abstract class ZEM extends AbstractTableGateway'."\n";
        $content .= '{'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @var array'."\n";
        $content .= '     */'."\n";
        $content .= '    protected $where = array();'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @var string'."\n";
        $content .= '     */'."\n";
        $content .= '    protected $primaryKey = null;'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @var string'."\n";
        $content .= '     */'."\n";
        $content .= '    protected $secondaryKey = null;'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @var Application $app'."\n";
        $content .= '     */'."\n";
        $content .= '    protected $app = null;'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @param Application $app'."\n";
        $content .= '     * @param $configArray'."\n";
        $content .= '     */'."\n";
        $content .= '    public function __construct($configArray, $app)'."\n";
        $content .= '    {'."\n";
        $content .= '        $this->adapter = new Adapter($configArray);'."\n";
        $content .= '        $this->app     = $app;'."\n";
        $content .= '        $this->sql     = new Sql($this->adapter, $this->table);'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * Builds a domain object from a ZDB row.'."\n";
        $content .= '     * Must be overridden by child classes.'."\n";
        $content .= '     * '."\n";
        $content .= '     * @param $row '."\n";
        $content .= '     */'."\n";
        $content .= '    protected abstract function buildZEntityObject($row);'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @param      $data'."\n";
        $content .= '     * @param null $data2'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return bool'."\n";
        $content .= '     */'."\n";
        $content .= '    protected function setWhere($data, $data2 = null)'."\n";
        $content .= '    {'."\n";
        $content .= '        // if is an instance of Entity Object set to array'."\n";
        $content .= '        if ($data instanceof Entity) {'."\n\n";
        $content .= '            $data = $data->toArray();'."\n";
        $content .= '        }'."\n";
        $content .= '        // if is an array'."\n";
        $content .= '        if (is_array($data)) {'."\n";
        $content .= '            if (array_key_exists($this->primaryKey, $data)) {'."\n";
        $content .= '                $this->where[$this->primaryKey] = $data[$this->primaryKey];'."\n";
        $content .= '            }'."\n";
        $content .= '            if (array_key_exists($this->secondaryKey, $data)) {'."\n";
        $content .= '                $this->where[$this->secondaryKey] =$data[$this->secondaryKey];'."\n";
        $content .= '            }'."\n";
        $content .= '            if(array_key_exists($this->primaryKey, $this->where) && $this->where[$this->primaryKey] != null){'."\n";
        $content .= '                return true;'."\n";
        $content .= '            }'."\n";
        $content .= '            return false;'."\n";
        $content .= '        }'."\n";
        $content .= '        if(is_numeric($data)){'."\n";
        $content .= '            // filter to INT'."\n";
        $content .= '            $data = filter_var($data, FILTER_VALIDATE_INT);'."\n";
        $content .= '            $this->where[$this->primaryKey] = $data;'."\n";
        $content .= '        }'."\n";
        $content .= '        if(ctype_alnum($data)){'."\n";
        $content .= '            // filter to INT'."\n";
        $content .= '            $this->where[$this->primaryKey] = $data;'."\n";
        $content .= '        }'."\n";
        $content .= '        if(is_numeric($data2)){'."\n";
        $content .= '            // filter to INT'."\n";
        $content .= '            $data2 = filter_var($data2, FILTER_VALIDATE_INT);'."\n";
        $content .= '            $this->where[$this->secondaryKey] = $data2;'."\n";
        $content .= '        }'."\n";
        $content .= '        if(ctype_alnum($data2)){'."\n";
        $content .= '            // filter to INT'."\n";
        $content .= '            $this->where[$this->secondaryKey] = $data2;'."\n";
        $content .= '        }'."\n";
        $content .= '        if($this->where){'."\n";
        $content .= '            return true;'."\n";
        $content .= '        }'."\n";
        $content .= '        return false;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @return array Entities'."\n";
        $content .= '     */'."\n";
        $content .= '    public function findAll()'."\n";
        $content .= '    {'."\n";
        $content .= '        $select = $this->sql->select();'."\n";
        $content .= '        $result = $this->selectWith($select)->toArray();'."\n";
        $content .= '        $entities = array();'."\n";
        $content .= '        foreach ($result as $row) {'."\n";
        $content .= '            $entities[] = $this->buildZEntityObject($row);'."\n";
        $content .= '        }'."\n\n";
        $content .= '        return $entities;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @param array $where'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return array Entities'."\n";
        $content .= '     */'."\n";
        $content .= '    public function find(array $where)'."\n";
        $content .= '    {'."\n";
        $content .= '        $select = $this->sql->select();'."\n";
        $content .= '        $select->where($where);'."\n";
        $content .= '        $result = $this->selectWith($select)->toArray();'."\n";
        $content .= '        $entities = array();'."\n";
        $content .= '        foreach ($result as $row) {'."\n";
        $content .= '            $entities[] = $this->buildZEntityObject($row);'."\n";
        $content .= '        }'."\n\n";
        $content .= '        return $entities;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * @param int      $data'."\n";
        $content .= '     * @param int|null $data2'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return bool|Entity'."\n";
        $content .= '     */'."\n";
        $content .= '     protected function findOneEntityById($data, $data2 = null)'."\n";
        $content .= '     {'."\n";
        $content .= '         $entity = false;'."\n";
        $content .= '         if($this->setWhere($data, $data2)){'."\n\n";
        $content .= '             $select = $this->sql->select();'."\n";
        $content .= '             $select->where($this->where);'."\n";
        $content .= '             $row = $this->selectWith($select)->current();'."\n";
        $content .= '             if($row){'."\n";
        $content .= '                 $entity = $this->buildZEntityObject($row);'."\n";
        $content .= '             }'."\n";
        $content .= '         }'."\n";
        $content .= '         return $entity;'."\n";
        $content .= '     }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * Create Entity'."\n";
        $content .= '     * '."\n";
        $content .= '     * @param array $data | Entity $data'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return bool'."\n";
        $content .= '     */'."\n";
        $content .= '    public function createEntity($data)'."\n";
        $content .= '    {'."\n";
        $content .= '        if ($data instanceof Entity) {'."\n";
        $content .= '            $data = $data->toArray();'."\n";
        $content .= '            if ($data[$this->primaryKey] == null) {'."\n";
        $content .= '                if($this->insert($data)){'."\n";
        $content .= '                    return true;'."\n";
        $content .= '                }'."\n";
        $content .= '                return false;'."\n";
        $content .= '            }'."\n";
        $content .= '            if ($data[$this->secondaryKey] && $data[$this->primaryKey]) {'."\n";
        $content .= '                if(!$this->findOneById($data[$this->secondaryKey], $data[$this->primaryKey])){'."\n";
        $content .= '                    if($this->insert($data)){'."\n";
        $content .= '                        return true;'."\n";
        $content .= '                    };'."\n";
        $content .= '                    return false;'."\n";
        $content .= '                }'."\n";
        $content .= '                return false;'."\n";
        $content .= '            }'."\n";
        $content .= '        }'."\n";
        $content .= '        return false;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * Save Entity'."\n";
        $content .= '     * '."\n";
        $content .= '     * @param Entity|array $entity'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return bool'."\n";
        $content .= '     */'."\n";
        $content .= '    public function saveEntity($entity)'."\n";
        $content .= '    {'."\n";
        $content .= '        if($entity instanceof Entity){'."\n";
        $content .= '            $entity = $entity->toArray();'."\n";
        $content .= '        }'."\n\n";
        $content .= '        if ($this->setWhere($entity))  {'."\n";
        $content .= '            if($this->update($entity, $this->where)){'."\n";
        $content .= '                return true;'."\n";
        $content .= '            }'."\n";
        $content .= '            return false;'."\n";
        $content .= '        }'."\n";
        $content .= '        if($this->insert($entity)){'."\n";
        $content .= '            return true;'."\n";
        $content .= '        }'."\n";
        $content .= '        return false;'."\n";
        $content .= '    }'."\n\n";
        $content .= '    /**'."\n";
        $content .= '     * Delete Entity'."\n";
        $content .= '     * '."\n";
        $content .= '     * @param Entity $data'."\n";
        $content .= '     * '."\n";
        $content .= '     * @return bool'."\n";
        $content .= '     */'."\n";
        $content .= '    public function deleteEntity($data)'."\n";
        $content .= '    {'."\n";
        $content .= '        if($this->setWhere($data)){'."\n";
        $content .= '            $this->delete($this->where);'."\n";
        $content .= '            return true;'."\n";
        $content .= '        }'."\n";
        $content .= '        return false;'."\n";
        $content .= '    }'."\n";
        $content .= '}'."\n";

        return $content;
    }

}