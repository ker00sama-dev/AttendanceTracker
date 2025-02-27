<?php

namespace App\Filament\Resources\LectureResource\Pages;

use App\Filament\Resources\LectureResource;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Filament\Infolists\Components\htmlEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewLecture extends ViewRecord
{
  protected static string $resource = LectureResource::class;


  //QR Code Generation
  public function qr_codeSvg($data)
  {
    $svg = (new Writer(
      new ImageRenderer(
        new RendererStyle(192, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
        new SvgImageBackEnd
      )
    ))->writeString($data);


    return $svg;

  }

  public function infolist(Infolist $infolist): Infolist
  {
    return $infolist->schema([
      TextEntry::make('topic')
        ->label(__('Topic'))
        ->extraAttributes([
          'style' => 'font-size: 24px; font-weight: bold; color: #333; margin-bottom: 10px;',
        ]),

      TextEntry::make('subject.name')
        ->label(__('Subject'))
        ->extraAttributes([
          'style' => 'font-size: 20px; color: #555; margin-bottom: 5px;',
        ]),

      TextEntry::make('creator.name')
        ->label(__('Creator'))
        ->extraAttributes([
          'style' => 'font-size: 18px; color: #666; margin-bottom: 5px;',
        ]),

      TextEntry::make('start_time')
        ->label(__('Start Time'))
        ->dateTime()
        ->extraAttributes([
          'style' => 'font-size: 18px; color: #777; margin-bottom: 15px;',
        ]),

      TextEntry::make('subject.professor.name')
        ->label(__('Professor'))
        ->extraAttributes([
          'style' => 'font-size: 18px; color: #555;',
        ]),

      TextEntry::make('subject.instructor.name')
        ->label(__('Instructor'))
        ->extraAttributes([
          'style' => 'font-size: 18px; color: #555; margin-bottom: 20px;',
        ]),

      ImageEntry::make('qr_code')
        ->height('300px')
        ->label(__('QR Code'))
        ->defaultImageUrl(function ($record) {
          return "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" . urlencode(route('scan', $record->id));
        }),


// TODO: Implement the following code in the infolist
//      TextEntry::make('qr_code')
//        ->label(__('QR Code'))
//        ->formatStateUsing(fn (string $state): HtmlString => new HtmlString(self::generateQrCodeSvg($state->id))),


      // Expiration Notice
      TextEntry::make('qr_expiry_notice')
        ->label(__('QR Code Expiration'))
        ->state(fn() => __('This QR code will expire 30 minutes after the lecture starts.')),

    ]);
  }

}
