<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
  protected static ?string $model = Attendance::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  protected static ?int $navigationSort = 202;


  public static function getPluralModelLabel(): string
  {
    return __('Attendances');
  }

  public static function getModelLabel(): string
  {
    return __('Attendance');
  }

  public static function getBreadcrumb(): string
  {
    return __('Attendances');
  }


  public static function getNavigationLabel(): string
  {
    return __('Attendances');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Lectures');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('lecture_id')
          ->relationship('lecture', 'topic')
          ->label(__('Lecture'))
          ->required(),
        Forms\Components\Select::make('student_id')
          ->relationship('student', 'name')
          ->label(__('Student'))
          ->required(),
        Forms\Components\DateTimePicker::make('scanned_at')
          ->label(__('Scanned At'))
          ->native(false),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('lecture.topic')
          ->label(__('Lecture'))
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('student.name')
          ->label(__('Student'))
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('scanned_at')
          ->label(__('Scanned At'))
          ->dateTime()
          ->sortable(),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListAttendances::route('/'),
//            'create' => Pages\CreateAttendance::route('/create'),
//            'edit' => Pages\EditAttendance::route('/{record}/edit'),
    ];
  }
}
