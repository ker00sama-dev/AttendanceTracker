<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-users';

  protected static ?int $navigationSort = 1;

  public static function canView(Model $record): bool
  {
    return $record->role == 'admin';
  }

  public static function getPluralModelLabel(): string
  {
    return __('Users');
  }

  public static function getModelLabel(): string
  {
    return __('User');
  }

  public static function getBreadcrumb(): string
  {
    return __('Users');
  }

  public static function getNavigationLabel(): string
  {
    return __('Users');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('User Management');
  }

  public static function form(Form $form): Form
  {

    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->label(__('Name'))
          ->required()
          ->maxLength(255)
          ->rules(['required', 'string', 'max:255']),
        Forms\Components\TextInput::make('email')
          ->label(__('Email'))
          ->email()
          ->required()
          ->rules(function (?Model $record) {
            return [
              'required',
              'email',
              'unique:users,email,' . optional($record)->id . ',id',
            ];
          })
          ->maxLength(255),


        Forms\Components\TextInput::make('password')
          ->password()
          ->required()
          ->hiddenOn('edit'),
        Forms\Components\Select::make('role')
          ->label(__('Role'))
          ->options([
            'admin' => __('Admin'),
            'instructor' => __('Instructor'),
            'professor' => __('professor'),
            'student' => __('Student'),
          ])
          ->required()
          ->rules(['required', 'in:admin,instructor,student,professor']),

        Forms\Components\TextInput::make('college_card_id')
          ->label(__('College Card ID'))
          ->numeric()
          ->rules(function (?Model $record) {
            return [
              'numeric',
              'unique:users,college_card_id,' . optional($record)->id . ',id',
            ];
          }),

        Forms\Components\TextInput::make('phone_number')
          ->label(__('Phone Number'))
          ->tel()
          ->maxLength(15)
          ->rules(function (?Model $record) {
            return [
              'nullable',
              'unique:users,phone_number,' . optional($record)->id . ',id',
            ];
          }),
        Forms\Components\DateTimePicker::make('email_verified_at')
          ->label(__('Email Verified At'))
          ->rules(['nullable', 'date']),

        Forms\Components\Textarea::make('two_factor_secret')
          ->label(__('Two Factor Secret'))
          ->columnSpanFull()
          ->rules(['nullable']),

        Forms\Components\Textarea::make('two_factor_recovery_codes')
          ->label(__('Two Factor Recovery Codes'))
          ->columnSpanFull()
          ->rules(['nullable']),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('id')
          ->label(__('ID'))
          ->sortable(),

        Tables\Columns\TextColumn::make('college_card_id')
          ->label(__('College ID Number'))
          ->sortable(),

        Tables\Columns\TextColumn::make('name')
          ->label(__('Name'))
          ->sortable()
          ->searchable(),

        Tables\Columns\TextColumn::make('email')
          ->label(__('Email'))
          ->sortable()
          ->searchable(),

        Tables\Columns\BadgeColumn::make('role')
          ->label(__('Role'))
          ->colors([
            'primary' => 'admin',
            'success' => 'professor',
            'success' => 'instructor',
            'primary' => 'student',

          ])
          ->formatStateUsing(fn(string $state): string => __($state)),

        Tables\Columns\TextColumn::make('phone_number')
          ->label(__('Phone Number')),

        Tables\Columns\TextColumn::make('created_at')
          ->label(__('Created At'))
          ->dateTime('d/m/Y'),
      ])
      ->filters([])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->action(function (Model $record) {
            if ($record->id === 1) {
              Notification::make()->title(__('Cannot delete user with ID 1'))->danger()->send();
              return;
            }

            $record->delete();
          })
          ->disabled(fn(Model $record) => $record->id == 1), // Disable delete button for user with id = 1
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make()
          ->action(function ($records) {
            if ($records->contains(fn(Model $record) => $record->id === 1)) {
              Notification::make()->title(__('Cannot delete user with ID 1'))->danger()->send();
              return;
            }

            $records->each->delete();
          }),
      ]);
  }

  public static function getRelations(): array
  {
    return [];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }

  public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
  {
    if (auth()->user()->role == 'instructor') {
      return false;
    }

    return true;

  }

}
