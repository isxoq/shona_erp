<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 10.08.2021, 14:40
 */

namespace common\components\word;


use common\components\Formula;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Cell;

class SiydikWord extends WordBase
{

    public $rowsPerPage = 18;

    public $filePrefix = 'Siydik tahlillari jurnali';

    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     */
    public function renderTableHeader($table)
    {
        $cellStyle = ['valign' => 'center'];
        $cellPStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];
        $cellRowSpan = ['vMerge' => 'restart'];
        $cellRowContinue = ['vMerge' => 'continue'];
        $rowspanCellStyle = array_merge($cellStyle, $cellRowSpan);

        $table->addRow(Converter::cmToTwip(0.42));

        $table->addCell(Converter::cmToTwip(1.5), $rowspanCellStyle)->addText('№', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(5), $rowspanCellStyle)->addText('F.I.SH', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), $rowspanCellStyle)->addText("Yoshi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(5), $rowspanCellStyle)->addText("Manzil", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(5), $rowspanCellStyle)->addText("Yuborgan vrachi", null, $cellPStyle);


        $table->addCell(Converter::cmToTwip(7), ['valign' => 'center', 'gridSpan' => 7])->addText("Makroskopiya", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(10), ['valign' => 'center', 'gridSpan' => 10])->addText("Mikroskopiya", null, $cellPStyle);


//        second row
        $table->addRow(Converter::cmToTwip(0.42));

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);


        // Makroskopiya elementlari
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Miqdori", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Rangi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Tiniqligi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Solishtirma og'irligi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Reaksiyasi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Oqsil", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Glyukoza", null, $cellPStyle);

        // Makroskopiya elementlari
        $table->addCell(Converter::cmToTwip(3), ['valign' => 'center', 'gridSpan' => 3])
            ->addText("Epiteliy", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Leykotsit", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(2), ['valign' => 'center', 'gridSpan' => 2])
            ->addText("Eritrosit", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Silindr", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Bakteriya", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Droj. gribok", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR, 'vMerge' => 'restart'])
            ->addText("Tuz", null, $cellPStyle);


        //        third row
        $table->addRow(Converter::cmToTwip(2));

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('yassi', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("o'tuvchi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('buyrak', null, $cellPStyle);

        $table->addCell(null, $cellRowContinue);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("o'zgargan", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("o'zgarmagan", null, $cellPStyle);

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

    }

    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     * @param \common\models\AnalizGroup[] $analizGroups
     */
    public function renderTableContent($table, $analizGroups)
    {

        foreach ($analizGroups as $analizGroup) {

            $table->addRow(Converter::cmToTwip(0.2));

            $cellStyle = ['valign' => 'center'];
            $cellPStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

            $table->addCell(null, $cellStyle)->addText($analizGroup->orderedNumber, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->lastnameAndFirstname, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->age , null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->address, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->analiz->doctor->name ?? '', null, $cellPStyle);

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_miq_ml'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_rangi'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_tiniqligi'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_sol_ogirligi'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_reaksiya'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_oqsil_gl'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_glyukoza_gfoiz'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_epiteliy_yassi'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_epiteliy_otuvchi'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_epiteliy_buyrak'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_leykotsitlar'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_eritrotsitlar_ozgargan'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_eritrotsitlar_ozgarmagan'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_silindrlar'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_bakteriyalar'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_droj_gribk'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('sy_tuzlar'), null, $cellPStyle);

        }

    }

}