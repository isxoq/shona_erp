<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 10.08.2021, 14:40
 */

namespace common\components\word;


use common\components\Formula;
use PhpOffice\PhpWord\Shared\Converter;

class UmumiyQonWord extends WordBase
{

    public $rowsPerPage = 18;

    public $filePrefix = 'Umumiy qon jurnali';

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

        $table->addCell(Converter::cmToTwip(0.87), $rowspanCellStyle)->addText('№', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(2.34), $rowspanCellStyle)->addText('F.I.SH', null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.86), $rowspanCellStyle)->addText("Tug'ilgan sanasi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(5), $rowspanCellStyle)->addText("Manzil", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(2.33), $rowspanCellStyle)->addText("Yuborgan vrachi", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.27), $rowspanCellStyle)->addText("НВ", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.4), $rowspanCellStyle)->addText("Er (RBC)", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.24), $rowspanCellStyle)->addText("R.k.", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.25), $rowspanCellStyle)->addText("Trom (PLT)", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.46), $rowspanCellStyle)->addText("Leyk (WBC)", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.41), $rowspanCellStyle)->addText("Gemot (HCT)", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(9), ['valign' => 'center', 'gridSpan' => 6])->addText("Formula", null, $cellPStyle);

        $table->addCell(Converter::cmToTwip(1.46), $rowspanCellStyle)->addText("ECHT", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.46), $rowspanCellStyle)->addText("Ivish vaqti", null, $cellPStyle);

//        second row
        $table->addRow(Converter::cmToTwip(0.42));

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

        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("tayoq", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("segm", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("Eoz", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("Bazof", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("Limf", null, $cellPStyle);
        $table->addCell(Converter::cmToTwip(1.5), $cellStyle)->addText("Monots", null, $cellPStyle);

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
            $table->addCell(null, $cellStyle)->addText(date('d.m.Y', $analizGroup->client->born_date), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->client->address, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->analiz->doctor->name ?? '', null, $cellPStyle);

            /** @var int|float|null Gemoglobin (HB) */
            $hb = $analizGroup->getResultByIndicatorSlug('qu_hb');

            /** @var int|float|null Eritrositlar (RBC) */
            $rbc = $analizGroup->getResultByIndicatorSlug('qu_rbc');

            // Rank ko'rsatkichini hisoblash
            $rang_k = Formula::computeRangKorsatkich($hb, $rbc);

            $table->addCell(null, $cellStyle)->addText($hb, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($rbc, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($rang_k, null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_plt'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_wbs'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_hct'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_tyn'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_syn'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_eozinofil'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_bazofil'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_limfosit'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_monosit'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_echt'), null, $cellPStyle);
            $table->addCell(null, $cellStyle)->addText($analizGroup->getResultByIndicatorSlug('qu_ivish_vaqti'), null, $cellPStyle);

        }

    }

}