<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LectureResource\Pages;
use App\Models\Lecture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LectureResource extends Resource
{
  protected static ?string $model = Lecture::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?int $navigationSort = 201;



  public static function getPluralModelLabel(): string
  {
    return __('Lectures');
  }

  public static function getModelLabel(): string
  {
    return __('Lecture');
  }

  public static function getBreadcrumb(): string
  {
    return __('Lectures');
  }



  public static function getNavigationLabel(): string
  {
    return __('Lectures');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Lectures');
  }

  public static function form(Form $form): Form
  {
    return $form->schema([
      Forms\Components\TextInput::make('topic')
        ->label(__('Topic'))
        ->required()
        ->maxLength(255)
        ->placeholder(__('Enter the topic of the lecture')),

      Forms\Components\Select::make('subject_id')
        ->label(__('Subject'))
        ->options(function () {
          $query = \App\Models\Subject::query();

          // Apply role-based filtering
          if (auth()->user()->role === 'instructor' || auth()->user()->role === 'professor') {
            $query->where('created_by', auth()->id());
          }

          // Fetch the filtered subjects and return as key-value pairs
          return $query->pluck('name', 'id')->toArray();
        })
        ->required()
        ->searchable()
        ->placeholder(__('Select a subject')),

      Forms\Components\DateTimePicker::make('start_time')
        ->label(__('Start Time'))
        ->native(false)
        ->required()
        ->default(now())
        ->placeholder(__('Select the start time of the lecture')),
    ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->modifyQueryUsing(function (Builder $query) {
        return auth()->user()->role === 'instructor' || auth()->user()->role === 'professor'
          ? $query->where('created_by', auth()->id())
          : $query;
      })
      ->columns([
        // Lecture Topic
        Tables\Columns\TextColumn::make('topic')
          ->label(__('Topic'))
          ->searchable()
          ->sortable(),

        // Subject Name
        Tables\Columns\TextColumn::make('subject.name')
          ->label(__('Subject'))
          ->badge()
          ->searchable()
          ->sortable(),

        // Department Name
        Tables\Columns\TextColumn::make('subject.department.name')
          ->label(__('Department'))
          ->searchable()
          ->badge()
          ->sortable()
          ->formatStateUsing(fn(string $state): string => __($state)),

        // Professor Name
        Tables\Columns\TextColumn::make('subject.professor.name')
          ->label(__('Professor'))
          ->searchable()
          ->sortable(),

        // Instructor Name
        Tables\Columns\TextColumn::make('subject.instructor.name')
          ->label(__('Instructor'))
          ->searchable()
          ->sortable(),

        // College Year
        Tables\Columns\TextColumn::make('subject.collegeYear.year_name')
          ->label(__('College Year'))
          ->searchable()
          ->badge()
          ->sortable()
          ->formatStateUsing(fn(string $state): string => __($state)),

        // Lecture Start Time
        Tables\Columns\TextColumn::make('start_time')
          ->label(__('Start Time'))
          ->dateTime()
          ->sortable(),

        // Created At (toggleable)
        Tables\Columns\TextColumn::make('created_at')
          ->label(__('Created At'))
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),

        // Updated At (toggleable)
        Tables\Columns\TextColumn::make('updated_at')
          ->label(__('Updated At'))
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        // Optional filters can be added here
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\ViewAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      // Add relation managers if needed
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListLectures::route('/'),
      'create' => Pages\CreateLecture::route('/create'),
      'edit' => Pages\EditLecture::route('/{record}/edit'),
      'view' => Pages\ViewLecture::route('/{record}'),
    ];
  }
}
