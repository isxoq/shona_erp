<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 12.08.2021, 14:24
 */

namespace common\components\word;


use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Cell;

class AjralmaWord extends WordBase
{

    public $rowsPerPage = 18;

    public $filePrefix = 'Biologik ajralma tahlili';

    public function renderTableHeader($table)
    {

        $cellParahraphStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

//        first row
        $table->addRow(Converter::cmToTwip(0.5));

        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Umumiy №', null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText('Kunlik №', null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText('F.I.SH', null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(1.25), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Tug'ilgan yili", null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText("Yashash manzili", null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(4), ['valign' => 'center', 'vMerge' => 'restart'])
            ->addText("Yuborgan vrachi", null, $cellParahraphStyle);

        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 21])
            ->addText("Najas tahlili", null, $cellParahraphStyle);


        //        second row
        $table->addRow(Converter::cmToTwip(0.5));

        $this->generateNullCells($table, 6);

        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 5])
            ->addText("Makroskopiya", null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Bo'yash usuli", null, $cellParahraphStyle);

        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 15])
            ->addText("Mikroskopiya", null, $cellParahraphStyle);

//        third row

        $table->addRow(Converter::cmToTwip(1));
        $this->generateNullCells($table, 6);
        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Miqdori", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Shakli", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Reaksiya", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Shilimshiq", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(0.75), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Qon", null, $cellParahraphStyle);

        $table->addCell(null, ['vMerge' => 'continue']);
        $table->addCell(null, ['valign' => 'center', 'gridSpan' => 2])
            ->addText("Mushak tolalari", null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("O'simlik tolalari", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Neytral yog'", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Yog' kislota", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Sovun", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Kraxmal", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Yod floarasi", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Kristallar", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Shilliq", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Epiteliy", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Leykotsitlar", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Eritrosit", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Gijja tuxumlari", null, $cellParahraphStyle);
        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'vMerge' => 'restart', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Zamburug'", null, $cellParahraphStyle);

//        4th row

        $table->addRow(Converter::cmToTwip(1.8));
        $this->generateNullCells($table, 12);

        $table->addCell(Converter::cmToTwip(1), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Yaqqol ko'rinish", null, $cellParahraphStyle);

        $table->addCell(Converter::cmToTwip(1.5), ['valign' => 'center', 'textDirection' => Cell::TEXT_DIR_BTLR])
            ->addText("Yaqqol bo'lmagan ko'rinish", null, $cellParahraphStyle);
        $this->generateNullCells($table, 13);

    }

    public function renderTableContent($table, $analizGroups)
    {
        foreach ($analizGroups as $analizGroup) {

            $table->addRow(Converter::cmToTwip(0.5));

            $cellStyle = ['valign' => 'center'];
            $cellParagraphStyle = ['alignment' => 'center', 'spaceAfter' => 2, 'spaceBefore' => 2];

            $table->addCell(null, $cellStyle)->addText($analizGroup->orderedNumber, null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getDailyNumber(), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->lastnameAndFirstname, null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText(date('Y', $analizGroup->created_at), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->address, null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->analiz->doctor->name ?? '', null, $cellParagraphStyle);

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_miqdori'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_shakli'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText( $analizGroup->getResultByIndicatorSlug('biologik_ajralma_muhit'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText( 'shil');

            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_qon'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText('b.u.', null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_m_t_h_b'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_m_t_h_b_magan'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_h_b_o_t'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_ney_yog'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_yog_kis'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_sovun'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_kraxmal'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_y_flora'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_kristallar'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_shilliq'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_epiteliy'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_leykotsitlar'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_eritrotsit'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_gij_tuxum'), null, $cellParagraphStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('biologik_ajralma_zamburug'), null, $cellParagraphStyle);

        }
    }
}