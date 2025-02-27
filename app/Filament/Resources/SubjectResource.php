<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\CollegeYear;
use App\Models\Departments;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
  protected static ?string $model = Subject::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  protected static ?int $navigationSort = 200;


  public static function getPluralModelLabel(): string
  {
    return __('Subjects');
  }

  public static function getModelLabel(): string
  {
    return __('Subject');
  }

  public static function getBreadcrumb(): string
  {
    return __('Subjects');
  }



  public static function getNavigationLabel(): string
  {
    return __('Subjects');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Subjects');
  }


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->label(__('Name'))
          ->required()
          ->maxLength(255),
        Forms\Components\Select::make('professor_id')
          ->label(__('Professor'))
          ->relationship('professor', 'name', modifyQueryUsing: function ($query) {
            return $query->where('role', 'professor');
          })
          ->required(),
        Forms\Components\Select::make('instructor_id')
          ->label(__('Instructor'))
          ->relationship('instructor', 'name', modifyQueryUsing: function ($query) {
            return $query->where('role', 'instructor');
          }),
        //department_id
        Forms\Components\Select::make('department_id')
          ->label(__('Department'))
          ->relationship('department', 'name')
          ->options(
            Departments::all()->pluck('name', 'id')->mapWithKeys(function ($value, $key) {
              return [$key => __($value)]; // Translate each department name dynamically
            })->toArray()
          )
          ->required(),
        Forms\Components\Select::make('college_year_id')
          ->label(__('College Year'))
          ->relationship('collegeYear', 'year_name')
          ->options(
            CollegeYear::all()->pluck('year_name', 'id')->mapWithKeys(function ($value, $key) {
              return [$key => __($value)];
            })->toArray()
          )
          ->required(),
        Forms\Components\Textarea::make('description')
          ->label(__('Description'))
          ->columnSpanFull()
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->label(__('Name'))
          ->searchable(),
        Tables\Columns\TextColumn::make('professor.name')
          ->searchable()
          ->label(__('Professor')),
        Tables\Columns\TextColumn::make('instructor.name')
          ->searchable()
          ->placeholder('N/A')
          ->label(__('Instructor')),
        Tables\Columns\TextColumn::make('collegeYear.year_name')
          ->searchable()
          ->badge()
          ->label(__('College Year'))
          ->formatStateUsing(fn(string $state): string => __($state)),

        // department_id
        Tables\Columns\TextColumn::make('department.name')
          ->searchable()
          ->badge()
          ->label(__('Department'))
          ->formatStateUsing(fn(string $state): string => __($state)),

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
      'index' => Pages\ListSubjects::route('/'),
//      'create' => Pages\CreateSubject::route('/create'),
//      'edit' => Pages\EditSubject::route('/{record}/edit'),
    ];
  }
}
