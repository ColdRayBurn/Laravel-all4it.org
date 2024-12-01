<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Услуги';
    protected static ?string $modelLabel = 'услуга';
    protected static ?string $pluralLabel = 'Список услуг';
    protected static ?string $navigationIcon = 'heroicon-c-wrench';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Активность')
                    ->schema([
                        Forms\Components\Checkbox::make('isActive')
                            ->label('Активен')
                            ->default(true),
                        Forms\Components\Select::make('language_id')
                            ->label('Язык')
                            ->relationship(name: 'language', titleAttribute: 'name')
                            ->required(),
                        Forms\Components\TextInput::make('sort')
                            ->label('Сортировка')
                            ->numeric()
                            ->default(500)
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\TextInput::make('title')
                    ->label('Заголовок')
                    ->required(),
                Forms\Components\TextInput::make('priceFrom')
                    ->label('Цена от')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('time')
                    ->label('Сроки')
                    ->required(),
                Forms\Components\TextInput::make('shortDescription')
                    ->label('Краткое описание')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('Картинка')
                    //->image()
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3'
                    ])
                    ->disk('public'),
                Forms\Components\RichEditor::make('description')
                    ->label('Детальное описание')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                        'strike',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('isActive')
                    ->label('Активен')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language_id')
                    ->label('Язык')
                    ->getStateUsing(function ($record) {
                        return $record->language ? $record->language->flag : 'Не указано';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort')
                    ->label('Сортировка')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок'),
                Tables\Columns\TextColumn::make('priceFrom')
                    ->label('Цена'),
                Tables\Columns\TextColumn::make('shortDescription')
                    ->label('Краткое описание'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Картинка')
                    ->disk('public'),
            ])
            ->filters([
                SelectFilter::make('isActive')
                    ->label('Активность')
                    ->options([
                        1 => 'Да',
                        0 => 'Нет'
                    ]), //->default(1)
                SelectFilter::make('language_id')
                    ->label('Язык')
                    ->options(\App\Models\Language::pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->button()
                    ->color('info')
                    ->modal(false)
                    ->beforeReplicaSaved(function (Service $replica) {
                        $replica->title = 'КОПИЯ ' . $replica->title;
                        $replica->isActive = false;
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Удалить из меню.
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
