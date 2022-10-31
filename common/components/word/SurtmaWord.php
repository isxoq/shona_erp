<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 11.08.2021, 15:25
 */

namespace common\components\word;

use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Cell;

class SurtmaWord extends WordBase
{

    public $filePrefix = 'Surtma tahlili jurnali';

    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     */
    public function renderTableHeader($table)
    {
        $cellPStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

        $cellRowContinue = ['vMerge' => 'continue'];

        $table->addRow(Converter::cmToTwip(0.42));

        $table->addCell(Converter::cmToTwip(0.87), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('№', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('F.I.SH', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Yoshi', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('Manzili', null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('Yuborgan vrachi', null, $cellPStyle);


        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 9])
            ->addText('Vlagilishe (V)', null, $cellPStyle);

        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 2])
            ->addText('Ser(C)', null, $cellPStyle);

        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 2])
            ->addText('Ure(U)', null, $cellPStyle);


//        second row
        $table->addRow(Converter::cmToTwip(2.33));

        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText('Leykotsit', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Epit. kletka", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Sliz", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Gon Neyseri", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Trixomanad", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Dr. gribki", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Flora", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Gardinella", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Xlamidiya", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText('Leykotsit', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Epit. kletka", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText('Leykotsit', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])->addText("Epit. kletka", null, $cellPStyle);


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
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->age, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->address, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->analiz->doctor->name ?? '', null, $cellPStyle);

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_leyko'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_epiteliy_kletka'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_sliz'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_gon_neyseri'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_trixomanad'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_dr_gribki'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_flora'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_gardinella'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_vl_xlamidiya'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_se_leyko'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_se_epiteliy_kletka'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_u_leyko'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('surtma_u_epiteliy_kletka'), null, $cellPStyle);


        }

    }

}