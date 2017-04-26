<?php

namespace Sethorax\Fluidloader\Backend;

/**
 * Class BackendLayoutTransformer
 */
class BackendLayoutTransformer
{

    /**
     * @var string
     */
    protected $xmlLayout;

    /**
     * BackendLayoutTransformer constructor.
     *
     * @param string $xmlLayout
     */
    public function __construct($xmlLayout)
    {
        $this->xmlLayout = $xmlLayout;
    }

    /**
     * Check if XML configuration is valid
     *
     * @return bool
     */
    public function validateConfiguration()
    {
        $isValid = false;

        if (isset($this->xmlLayout)) {
            if (count($this->xmlLayout->xpath('row')) > 0 && count($this->xmlLayout->xpath('//row/column')) > 0) {
                $isValid = true;
            }
        }

        return $isValid;
    }

    /**
     * Transform XML configuration into TypoScript version
     *
     * @return string
     */
    public function transformToTypoScript()
    {
        $backendLayoutConfiguration = "backend_layout {\n";

        $rows = $this->xmlLayout->xpath('row');
        $rowCounter = 1;

        $colAndRowCounts = $this->calculateRowAndColCounts();

        $backendLayoutConfiguration .= 'colCount = ' . $colAndRowCounts['colCount'] . "\n";
        $backendLayoutConfiguration .= 'rowCount = ' . $colAndRowCounts['rowCount'] . "\n";

        $backendLayoutConfiguration .= "rows {\n";

        foreach ($rows as $row) {
            $backendLayoutConfiguration .= $rowCounter . " {\ncolumns {\n";

            $columns = $row->xpath('column');
            $columnCounter = 1;

            foreach ($columns as $column) {
                $name = (string) $column;
                $colPos = (string) $column->xpath('@pos')[0]->pos[0];
                $colspan = (string) $column->xpath('@colspan')[0]->colspan[0];

                $backendLayoutConfiguration .= $columnCounter . " {\n";
                $backendLayoutConfiguration .= 'name = ' . $name . "\n";
                $backendLayoutConfiguration .= 'colPos = ' . $colPos . "\n";
                if (!empty($colspan)) {
                    $backendLayoutConfiguration .= 'colspan = ' . $colspan . "\n";
                }
                $backendLayoutConfiguration .= "}\n";

                $columnCounter++;
            }

            $backendLayoutConfiguration .= "}\n}\n";

            $rowCounter++;
        }

        $backendLayoutConfiguration .= "}\n}\n";

        return $backendLayoutConfiguration;
    }

    /**
     * Count rows and columns and return it as an array
     *
     * @return array
     */
    protected function calculateRowAndColCounts()
    {
        $rowCount = count($this->xmlLayout->xpath('row'));
        $colCount = 0;

        $rows = $this->xmlLayout->xpath('row');

        foreach ($rows as $row) {
            $colCountInRow = count($row->xpath('column'));

            if ($colCount < $colCountInRow) {
                $colCount = $colCountInRow;
            }
        }

        return [
            'rowCount' => $rowCount,
            'colCount' => $colCount
        ];
    }
}
