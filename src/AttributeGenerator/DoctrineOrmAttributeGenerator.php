<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\AttributeGenerator;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\Model\Type\CompositeType;
use ApiPlatform\SchemaGenerator\Model\Use_;
use Nette\PhpGenerator\Literal;

use function Symfony\Component\String\u;

/**
 * Doctrine attribute generator.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class DoctrineOrmAttributeGenerator extends AbstractAttributeGenerator
{
    use GenerateIdentifierNameTrait;

    private const RESERVED_KEYWORDS = ['ABORT', 'ABORTSESSION', 'ABS', 'ABSOLUTE', 'ACCESS', 'ACCESSIBLE', 'ACCESS_LOCK', 'ACCOUNT', 'ACOS', 'ACOSH', 'ACTION', 'ADD', 'ADD_MONTHS', 'ADMIN', 'AFTER', 'AGGREGATE', 'ALIAS', 'ALL', 'ALLOCATE', 'ALLOW', 'ALTER', 'ALTERAND', 'AMP', 'ANALYSE', 'ANALYZE', 'AND', 'ANSIDATE', 'ANY', 'ARE', 'ARRAY', 'ARRAY_AGG', 'ARRAY_EXISTS', 'ARRAY_MAX_CARDINALITY', 'AS', 'ASC', 'ASENSITIVE', 'ASIN', 'ASINH', 'ASSERTION', 'ASSOCIATE', 'ASUTIME', 'ASYMMETRIC', 'AT', 'ATAN', 'ATAN2', 'ATANH', 'ATOMIC', 'AUDIT', 'AUTHORIZATION', 'AUX', 'AUXILIARY', 'AVE', 'AVERAGE', 'AVG', 'BACKUP', 'BEFORE', 'BEGIN', 'BEGIN_FRAME', 'BEGIN_PARTITION', 'BETWEEN', 'BIGINT', 'BINARY', 'BIT', 'BLOB', 'BOOLEAN', 'BOTH', 'BREADTH', 'BREAK', 'BROWSE', 'BT', 'BUFFERPOOL', 'BULK', 'BUT', 'BY', 'BYTE', 'BYTEINT', 'BYTES', 'CALL', 'CALLED', 'CAPTURE', 'CARDINALITY', 'CASCADE', 'CASCADED', 'CASE', 'CASESPECIFIC', 'CASE_N', 'CAST', 'CATALOG', 'CCSID', 'CD', 'CEIL', 'CEILING', 'CHANGE', 'CHAR', 'CHAR2HEXINT', 'CHARACTER', 'CHARACTERS', 'CHARACTER_LENGTH', 'CHARS', 'CHAR_LENGTH', 'CHECK', 'CHECKPOINT', 'CLASS', 'CLASSIFIER', 'CLOB', 'CLONE', 'CLOSE', 'CLUSTER', 'CLUSTERED', 'CM', 'COALESCE', 'COLLATE', 'COLLATION', 'COLLECT', 'COLLECTION', 'COLLID', 'COLUMN', 'COLUMN_VALUE', 'COMMENT', 'COMMIT', 'COMPLETION', 'COMPRESS', 'COMPUTE', 'CONCAT', 'CONCURRENTLY', 'CONDITION', 'CONNECT', 'CONNECTION', 'CONSTRAINT', 'CONSTRAINTS', 'CONSTRUCTOR', 'CONTAINS', 'CONTAINSTABLE', 'CONTENT', 'CONTINUE', 'CONVERT', 'CONVERT_TABLE_HEADER', 'COPY', 'CORR', 'CORRESPONDING', 'COS', 'COSH', 'COUNT', 'COVAR_POP', 'COVAR_SAMP', 'CREATE', 'CROSS', 'CS', 'CSUM', 'CT', 'CUBE', 'CUME_DIST', 'CURRENT', 'CURRENT_CATALOG', 'CURRENT_DATE', 'CURRENT_DEFAULT_TRANSFORM_GROUP', 'CURRENT_LC_CTYPE', 'CURRENT_PATH', 'CURRENT_ROLE', 'CURRENT_ROW', 'CURRENT_SCHEMA', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_TRANSFORM_GROUP_FOR_TYPE', 'CURRENT_USER', 'CURRVAL', 'CURSOR', 'CV', 'CYCLE', 'DATA', 'DATABASE', 'DATABASES', 'DATABLOCKSIZE', 'DATE', 'DATEFORM', 'DAY', 'DAYS', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DBCC', 'DBINFO', 'DEALLOCATE', 'DEC', 'DECFLOAT', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DEFERRABLE', 'DEFERRED', 'DEFINE', 'DEGREES', 'DEL', 'DELAYED', 'DELETE', 'DENSE_RANK', 'DENY', 'DEPTH', 'DEREF', 'DESC', 'DESCRIBE', 'DESCRIPTOR', 'DESTROY', 'DESTRUCTOR', 'DETERMINISTIC', 'DIAGNOSTIC', 'DIAGNOSTICS', 'DICTIONARY', 'DISABLE', 'DISABLED', 'DISALLOW', 'DISCONNECT', 'DISK', 'DISTINCT', 'DISTINCTROW', 'DISTRIBUTED', 'DIV', 'DO', 'DOCUMENT', 'DOMAIN', 'DOUBLE', 'DROP', 'DSSIZE', 'DUAL', 'DUMP', 'DYNAMIC', 'EACH', 'ECHO', 'EDITPROC', 'ELEMENT', 'ELSE', 'ELSEIF', 'EMPTY', 'ENABLED', 'ENCLOSED', 'ENCODING', 'ENCRYPTION', 'END', 'END-EXEC', 'ENDING', 'END_FRAME', 'END_PARTITION', 'EQ', 'EQUALS', 'ERASE', 'ERRLVL', 'ERROR', 'ERRORFILES', 'ERRORTABLES', 'ESCAPE', 'ESCAPED', 'ET', 'EVERY', 'EXCEPT', 'EXCEPTION', 'EXCLUSIVE', 'EXEC', 'EXECUTE', 'EXISTS', 'EXIT', 'EXP', 'EXPLAIN', 'EXTERNAL', 'EXTRACT', 'FALLBACK', 'FALSE', 'FASTEXPORT', 'FENCED', 'FETCH', 'FIELDPROC', 'FILE', 'FILLFACTOR', 'FILTER', 'FINAL', 'FIRST', 'FIRST_VALUE', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FLOOR', 'FOR', 'FORCE', 'FOREIGN', 'FORMAT', 'FOUND', 'FRAME_ROW', 'FREE', 'FREESPACE', 'FREETEXT', 'FREETEXTTABLE', 'FREEZE', 'FROM', 'FULL', 'FULLTEXT', 'FUNCTION', 'FUSION', 'GE', 'GENERAL', 'GENERATED', 'GET', 'GIVE', 'GLOBAL', 'GO', 'GOTO', 'GRANT', 'GRAPHIC', 'GROUP', 'GROUPING', 'GROUPS', 'GT', 'HANDLER', 'HASH', 'HASHAMP', 'HASHBAKAMP', 'HASHBUCKET', 'HASHROW', 'HAVING', 'HELP', 'HIGH_PRIORITY', 'HOLD', 'HOLDLOCK', 'HOST', 'HOUR', 'HOURS', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IDENTIFIED', 'IDENTITY', 'IDENTITYCOL', 'IDENTITY_INSERT', 'IF', 'IGNORE', 'ILIKE', 'IMMEDIATE', 'IN', 'INCLUSIVE', 'INCONSISTENT', 'INCREMENT', 'INDEX', 'INDICATOR', 'INFILE', 'INHERIT', 'INITIAL', 'INITIALIZE', 'INITIALLY', 'INITIATE', 'INNER', 'INOUT', 'INPUT', 'INS', 'INSENSITIVE', 'INSERT', 'INSTEAD', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTEGERDATE', 'INTERSECT', 'INTERSECTION', 'INTERVAL', 'INTO', 'IO_AFTER_GTIDS', 'IO_BEFORE_GTIDS', 'IS', 'ISNULL', 'ISOBID', 'ISOLATION', 'ITERATE', 'JAR', 'JOIN', 'JOURNAL', 'JSON_ARRAY', 'JSON_ARRAYAGG', 'JSON_EXISTS', 'JSON_OBJECT', 'JSON_OBJECTAGG', 'JSON_QUERY', 'JSON_TABLE', 'JSON_TABLE_PRIMITIVE', 'JSON_VALUE', 'KEEP', 'KEY', 'KEYS', 'KILL', 'KURTOSIS', 'LABEL', 'LAG', 'LANGUAGE', 'LARGE', 'LAST', 'LAST_VALUE', 'LATERAL', 'LC_CTYPE', 'LE', 'LEAD', 'LEADING', 'LEAVE', 'LEFT', 'LESS', 'LEVEL', 'LIKE', 'LIKE_REGEX', 'LIMIT', 'LINEAR', 'LINENO', 'LINES', 'LISTAGG', 'LN', 'LOAD', 'LOADING', 'LOCAL', 'LOCALE', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCATOR', 'LOCATORS', 'LOCK', 'LOCKING', 'LOCKMAX', 'LOCKSIZE', 'LOG', 'LOG10', 'LOGGING', 'LOGON', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOWER', 'LOW_PRIORITY', 'LT', 'MACRO', 'MAINTAINED', 'MAP', 'MASTER_BIND', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MATCHES', 'MATCH_NUMBER', 'MATCH_RECOGNIZE', 'MATERIALIZED', 'MAVG', 'MAX', 'MAXEXTENTS', 'MAXIMUM', 'MAXVALUE', 'MCHARACTERS', 'MDIFF', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MEMBER', 'MERGE', 'METHOD', 'MICROSECOND', 'MICROSECONDS', 'MIDDLEINT', 'MIN', 'MINDEX', 'MINIMUM', 'MINUS', 'MINUTE', 'MINUTES', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MLINREG', 'MLOAD', 'MLSLABEL', 'MOD', 'MODE', 'MODIFIES', 'MODIFY', 'MODULE', 'MONITOR', 'MONRESOURCE', 'MONSESSION', 'MONTH', 'MONTHS', 'MSUBSTR', 'MSUM', 'MULTISET', 'NAMED', 'NAMES', 'NATIONAL', 'NATURAL', 'NCHAR', 'NCLOB', 'NE', 'NESTED_TABLE_ID', 'NEW', 'NEW_TABLE', 'NEXT', 'NEXTVAL', 'NO', 'NOAUDIT', 'NOCHECK', 'NOCOMPRESS', 'NONCLUSTERED', 'NONE', 'NORMALIZE', 'NOT', 'NOTNULL', 'NOWAIT', 'NO_WRITE_TO_BINLOG', 'NTH_VALUE', 'NTILE', 'NULL', 'NULLIF', 'NULLIFZERO', 'NULLS', 'NUMBER', 'NUMERIC', 'NUMPARTS', 'OBID', 'OBJECT', 'OBJECTS', 'OCCURRENCES_REGEX', 'OCTET_LENGTH', 'OF', 'OFF', 'OFFLINE', 'OFFSET', 'OFFSETS', 'OLD', 'OLD_TABLE', 'OMIT', 'ON', 'ONE', 'ONLINE', 'ONLY', 'OPEN', 'OPENDATASOURCE', 'OPENQUERY', 'OPENROWSET', 'OPENXML', 'OPERATION', 'OPTIMIZATION', 'OPTIMIZE', 'OPTIMIZER_COSTS', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'ORDINALITY', 'ORGANIZATION', 'OUT', 'OUTER', 'OUTFILE', 'OUTPUT', 'OVER', 'OVERLAPS', 'OVERLAY', 'OVERRIDE', 'PACKAGE', 'PAD', 'PADDED', 'PARAMETER', 'PARAMETERS', 'PART', 'PARTIAL', 'PARTITION', 'PARTITIONED', 'PARTITIONING', 'PASSWORD', 'PATH', 'PATTERN', 'PCTFREE', 'PER', 'PERCENT', 'PERCENTILE_CONT', 'PERCENTILE_DISC', 'PERCENT_RANK', 'PERIOD', 'PERM', 'PERMANENT', 'PIECESIZE', 'PIVOT', 'PLACING', 'PLAN', 'PORTION', 'POSITION', 'POSITION_REGEX', 'POSTFIX', 'POWER', 'PRECEDES', 'PRECISION', 'PREFIX', 'PREORDER', 'PREPARE', 'PRESERVE', 'PREVVAL', 'PRIMARY', 'PRINT', 'PRIOR', 'PRIQTY', 'PRIVATE', 'PRIVILEGES', 'PROC', 'PROCEDURE', 'PROFILE', 'PROGRAM', 'PROPORTIONAL', 'PROTECTION', 'PSID', 'PTF', 'PUBLIC', 'PURGE', 'QUALIFIED', 'QUALIFY', 'QUANTILE', 'QUERY', 'QUERYNO', 'RADIANS', 'RAISERROR', 'RANDOM', 'RANGE', 'RANGE_N', 'RANK', 'RAW', 'READ', 'READS', 'READTEXT', 'READ_WRITE', 'REAL', 'RECONFIGURE', 'RECURSIVE', 'REF', 'REFERENCES', 'REFERENCING', 'REFRESH', 'REGEXP', 'REGR_AVGX', 'REGR_AVGY', 'REGR_COUNT', 'REGR_INTERCEPT', 'REGR_R2', 'REGR_SLOPE', 'REGR_SXX', 'REGR_SXY', 'REGR_SYY', 'RELATIVE', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REPLICATION', 'REPOVERRIDE', 'REQUEST', 'REQUIRE', 'RESIGNAL', 'RESOURCE', 'RESTART', 'RESTORE', 'RESTRICT', 'RESULT', 'RESULT_SET_LOCATOR', 'RESUME', 'RET', 'RETRIEVE', 'RETURN', 'RETURNING', 'RETURNS', 'REVALIDATE', 'REVERT', 'REVOKE', 'RIGHT', 'RIGHTS', 'RLIKE', 'ROLE', 'ROLLBACK', 'ROLLFORWARD', 'ROLLUP', 'ROUND_CEILING', 'ROUND_DOWN', 'ROUND_FLOOR', 'ROUND_HALF_DOWN', 'ROUND_HALF_EVEN', 'ROUND_HALF_UP', 'ROUND_UP', 'ROUTINE', 'ROW', 'ROWCOUNT', 'ROWGUIDCOL', 'ROWID', 'ROWNUM', 'ROWS', 'ROWSET', 'ROW_NUMBER', 'RULE', 'RUN', 'RUNNING', 'SAMPLE', 'SAMPLEID', 'SAVE', 'SAVEPOINT', 'SCHEMA', 'SCHEMAS', 'SCOPE', 'SCRATCHPAD', 'SCROLL', 'SEARCH', 'SECOND', 'SECONDS', 'SECOND_MICROSECOND', 'SECQTY', 'SECTION', 'SECURITY', 'SECURITYAUDIT', 'SEEK', 'SEL', 'SELECT', 'SEMANTICKEYPHRASETABLE', 'SEMANTICSIMILARITYDETAILSTABLE', 'SEMANTICSIMILARITYTABLE', 'SENSITIVE', 'SEPARATOR', 'SEQUENCE', 'SESSION', 'SESSION_USER', 'SET', 'SETRESRATE', 'SETS', 'SETSESSRATE', 'SETUSER', 'SHARE', 'SHOW', 'SHUTDOWN', 'SIGNAL', 'SIMILAR', 'SIMPLE', 'SIN', 'SINH', 'SIZE', 'SKEW', 'SKIP', 'SMALLINT', 'SOME', 'SOUNDEX', 'SOURCE', 'SPACE', 'SPATIAL', 'SPECIFIC', 'SPECIFICTYPE', 'SPOOL', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLTEXT', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SQRT', 'SS', 'SSL', 'STANDARD', 'START', 'STARTING', 'STARTUP', 'STATE', 'STATEMENT', 'STATIC', 'STATISTICS', 'STAY', 'STDDEV_POP', 'STDDEV_SAMP', 'STEPINFO', 'STOGROUP', 'STORED', 'STORES', 'STRAIGHT_JOIN', 'STRING_CS', 'STRUCTURE', 'STYLE', 'SUBMULTISET', 'SUBSCRIBER', 'SUBSET', 'SUBSTR', 'SUBSTRING', 'SUBSTRING_REGEX', 'SUCCEEDS', 'SUCCESSFUL', 'SUM', 'SUMMARY', 'SUSPEND', 'SYMMETRIC', 'SYNONYM', 'SYSDATE', 'SYSTEM', 'SYSTEM_TIME', 'SYSTEM_USER', 'SYSTIMESTAMP', 'TABLE', 'TABLESAMPLE', 'TABLESPACE', 'TAN', 'TANH', 'TBL_CS', 'TEMPORARY', 'TERMINATE', 'TERMINATED', 'TEXTSIZE', 'THAN', 'THEN', 'THRESHOLD', 'TIME', 'TIMESTAMP', 'TIMEZONE_HOUR', 'TIMEZONE_MINUTE', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TITLE', 'TO', 'TOP', 'TRACE', 'TRAILING', 'TRAN', 'TRANSACTION', 'TRANSLATE', 'TRANSLATE_CHK', 'TRANSLATE_REGEX', 'TRANSLATION', 'TREAT', 'TRIGGER', 'TRIM', 'TRIM_ARRAY', 'TRUE', 'TRUNCATE', 'TRY_CONVERT', 'TSEQUAL', 'TYPE', 'UC', 'UESCAPE', 'UID', 'UNDEFINED', 'UNDER', 'UNDO', 'UNION', 'UNIQUE', 'UNKNOWN', 'UNLOCK', 'UNNEST', 'UNPIVOT', 'UNSIGNED', 'UNTIL', 'UPD', 'UPDATE', 'UPDATETEXT', 'UPPER', 'UPPERCASE', 'USAGE', 'USE', 'USER', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALIDATE', 'VALIDPROC', 'VALUE', 'VALUES', 'VALUE_OF', 'VARBINARY', 'VARBYTE', 'VARCHAR', 'VARCHAR2', 'VARCHARACTER', 'VARGRAPHIC', 'VARIABLE', 'VARIADIC', 'VARIANT', 'VARYING', 'VAR_POP', 'VAR_SAMP', 'VCAT', 'VERBOSE', 'VERSIONING', 'VIEW', 'VIRTUAL', 'VOLATILE', 'VOLUMES', 'WAIT', 'WAITFOR', 'WHEN', 'WHENEVER', 'WHERE', 'WHILE', 'WIDTH_BUCKET', 'WINDOW', 'WITH', 'WITHIN', 'WITHIN_GROUP', 'WITHOUT', 'WLM', 'WORK', 'WRITE', 'WRITETEXT', 'XMLCAST', 'XMLEXISTS', 'XMLNAMESPACES', 'XOR', 'YEAR', 'YEARS', 'YEAR_MONTH', 'ZEROFILL', 'ZEROIFNULL', 'ZONE'];

    public function generateClassAttributes(Class_ $class): array
    {
        if ($class->isEnum()) {
            return [];
        }

        if ($class->isEmbeddable) {
            return [new Attribute('ORM\Embeddable')];
        }

        $attributes = [];
        if ($class->hasChild && ($inheritanceAttributes = $this->config['doctrine']['inheritanceAttributes'])) {
            foreach ($inheritanceAttributes as $configAttributes) {
                foreach ($configAttributes as $attributeName => $attributeArgs) {
                    $attributes[] = new Attribute($attributeName, $attributeArgs ?? []);
                }
            }
        } elseif ($class->isAbstract) {
            $attributes[] = new Attribute('ORM\MappedSuperclass');
        } elseif ($class->hasChild && $class->isReferencedBy) {
            $parentNames = [$class->name()];
            $childNames = [];
            while (!empty($parentNames)) {
                $directChildren = [];
                foreach ($parentNames as $parentName) {
                    $directChildren = array_merge($directChildren, array_filter($this->classes, fn (Class_ $childClass) => $parentName === $childClass->parent()));
                }
                $parentNames = array_keys($directChildren);
                $childNames = array_merge($childNames, array_keys(array_filter($directChildren, fn (Class_ $childClass) => !$childClass->isAbstract)));
            }
            $mapNames = array_merge([$class->name()], $childNames);

            $attributes[] = new Attribute('ORM\Entity');
            $attributes[] = new Attribute('ORM\InheritanceType', [\in_array($this->config['doctrine']['inheritanceType'], ['JOINED', 'SINGLE_TABLE', 'TABLE_PER_CLASS', 'NONE'], true) ? $this->config['doctrine']['inheritanceType'] : 'JOINED']);
            $attributes[] = new Attribute('ORM\DiscriminatorColumn', ['name' => 'discr']);
            $attributes[] = new Attribute('ORM\DiscriminatorMap', [array_reduce($mapNames, fn (array $map, string $mapName) => $map + [u($mapName)->camel()->toString() => new Literal(sprintf('%s::class', $mapName))], [])]);
        } else {
            $attributes[] = new Attribute('ORM\Entity');
        }

        foreach (self::RESERVED_KEYWORDS as $keyword) {
            if (0 !== strcasecmp($keyword, $class->name())) {
                continue;
            }

            $attributes[] = new Attribute('ORM\Table', ['name' => sprintf('`%s`', $this->generateIdentifierName($class->name(), 'table', $this->config))]);
        }

        return $attributes;
    }

    public function generatePropertyAttributes(Property $property, string $className): array
    {
        if (null === $property->type && null === $property->reference) {
            return [];
        }

        if ($property->isId) {
            return $this->generateIdAttributes();
        }

        $type = null;
        if ($property->isEnum) {
            $type = $property->isArray() ? 'simple_array' : 'string';
        } elseif (!$property->reference && $property->isArray()) {
            $type = 'json';
        } elseif ($property->type && !$property instanceof CompositeType && !$property->reference && !$property->isArray() && null !== ($phpType = $this->phpTypeConverter->getPhpType($property, $this->config, []))) {
            switch ($property->type) {
                case 'time':
                    $type = 'time';
                    break;
                case 'date':
                    $type = 'date';
                    break;
                case 'dateTime':
                    $type = 'datetime';
                    break;
                default:
                    $type = $phpType;
                    switch ($phpType) {
                        case 'bool':
                            $type = 'boolean';
                            break;
                        case 'int': // TODO: use more precise types for int (smallint, bigint...)
                            $type = 'integer';
                            break;
                        case 'string':
                            $type = 'text';
                            break;
                        case '\\'.\DateTimeInterface::class:
                            $type = 'datetime';
                            break;
                        case '\\'.\DateInterval::class:
                            $type = 'string';
                            break;
                    }
                    break;
            }
        }

        if (null !== $type) {
            $args = [];
            if ('string' !== $type) {
                $args['type'] = $type;
            }

            if ($property->isNullable) {
                $args['nullable'] = true;
            }

            if ($property->isUnique) {
                $args['unique'] = true;
            }

            foreach (self::RESERVED_KEYWORDS as $keyword) {
                if (0 === strcasecmp($keyword, $property->name())) {
                    $args['name'] = sprintf('`%s`', $property->name());
                    break;
                }
            }

            return [new Attribute('ORM\Column', $args)];
        }

        if (!$property->reference) {
            $this->logger ? $this->logger->error('There is no reference for the property "{property}" from the class "{class}"', ['property' => $property->name(), 'class' => $className]) : null;

            return [];
        }

        if (null === $relationName = $this->getRelationName($property)) {
            return [];
        }

        if ($property->isEmbedded) {
            return [new Attribute('ORM\Embedded', ['class' => $relationName])];
        }

        $relationTableName = $this->generateIdentifierName($className.ucfirst($property->reference->name()).ucfirst($property->name()), 'join_table', $this->config);

        $attributes = [];
        switch ($property->cardinality) {
            case CardinalitiesExtractor::CARDINALITY_0_1:
                $attributes[] = new Attribute('ORM\OneToOne', ['targetEntity' => $relationName]);
                break;
            case CardinalitiesExtractor::CARDINALITY_1_1:
                $attributes[] = new Attribute('ORM\OneToOne', ['targetEntity' => $relationName]);
                $attributes[] = new Attribute('ORM\JoinColumn', ['nullable' => false]);
                break;
            case CardinalitiesExtractor::CARDINALITY_UNKNOWN:
            case CardinalitiesExtractor::CARDINALITY_N_0:
                if (null !== $property->inversedBy) {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName]);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_1:
                if (null !== $property->inversedBy) {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName, 'inversedBy' => $property->inversedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToOne', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinColumn', ['nullable' => false]);
                break;
            case CardinalitiesExtractor::CARDINALITY_0_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = new Attribute('ORM\OneToMany', ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                // Self-referencing relation
                if ($className === $property->reference->name()) {
                    $attributes[] = new Attribute('ORM\InverseJoinColumn', ['name' => $this->generateIdentifierName($this->inflector->singularize($property->name())[0].ucfirst($property->reference->name()).'Id', 'inverse_join_column', $this->config), 'unique' => true]);
                } else {
                    $attributes[] = new Attribute('ORM\InverseJoinColumn', ['unique' => true]);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_1_N:
                if (null !== $property->mappedBy) {
                    $attributes[] = new Attribute('ORM\OneToMany', ['targetEntity' => $relationName, 'mappedBy' => $property->mappedBy]);
                } else {
                    $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                }
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                // Self-referencing relation
                if ($className === $property->reference->name()) {
                    $attributes[] = new Attribute('ORM\InverseJoinColumn', ['name' => $this->generateIdentifierName($this->inflector->singularize($property->name())[0].ucfirst($property->reference->name()).'Id', 'inverse_join_column', $this->config), 'nullable' => false, 'unique' => true]);
                } else {
                    $attributes[] = new Attribute('ORM\InverseJoinColumn', ['nullable' => false, 'unique' => true]);
                }
                break;
            case CardinalitiesExtractor::CARDINALITY_N_N:
                $attributes[] = new Attribute('ORM\ManyToMany', ['targetEntity' => $relationName]);
                $attributes[] = new Attribute('ORM\JoinTable', ['name' => $relationTableName]);
                break;
        }

        return $attributes;
    }

    public function generateUses(Class_ $class): array
    {
        return $class->isEnum() ? [] : [new Use_('Doctrine\ORM\Mapping', 'ORM')];
    }

    /**
     * @return Attribute[]
     */
    private function generateIdAttributes(): array
    {
        $attributes = [new Attribute('ORM\Id')];
        if ('none' !== $this->config['id']['generationStrategy'] && !$this->config['id']['writable']) {
            $attributes[] = new Attribute('ORM\GeneratedValue', ['strategy' => strtoupper($this->config['id']['generationStrategy'])]);
        }

        switch ($this->config['id']['generationStrategy']) {
            case 'uuid':
                $type = 'guid';
                break;
            case 'auto':
                $type = 'integer';
                break;
            default:
                $type = 'string';
                break;
        }

        $attributes[] = new Attribute('ORM\Column', ['type' => $type]);

        return $attributes;
    }

    /**
     * Gets class or interface name to use in relations.
     */
    private function getRelationName(Property $property): ?string
    {
        $reference = $property->reference;

        if (!$reference) {
            return null;
        }

        if (null !== $reference->interfaceName()) {
            if (isset($this->config['types'][$reference->name()]['namespaces']['interface'])) {
                return sprintf('%s\\%s', $this->config['types'][$reference->name()]['namespaces']['interface'], $reference->interfaceName());
            }

            return sprintf('%s\\%s', $this->config['namespaces']['interface'], $reference->interfaceName());
        }

        if (isset($this->config['types'][$reference->name()]['namespaces']['class'])) {
            return sprintf('%s\\%s', $this->config['types'][$reference->name()]['namespaces']['class'], $reference->name());
        }

        return sprintf('%s\\%s', $this->config['namespaces']['entity'], $reference->name());
    }
}
