<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingResource\Pages;
use App\Filament\Resources\PricingResource\RelationManagers;
use App\Models\Pricing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class PricingResource extends Resource
{
    protected static ?string $model = Pricing::class;
    protected static ?string $navigationGroup = 'Главная страница';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Прейскурант';
    protected static ?string $modelLabel = 'услуга';
    protected static ?string $pluralLabel = 'Список услуг';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->label('Название услуги')
                    ->required(),
                Forms\Components\TextInput::make('priceFrom')
                    ->label('Цена от')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('time')
                    ->label('Сроки')
                    ->required(),
                Forms\Components\Checkbox::make('isHighlighted')
                    ->label('Выделен')
                    ->default(false),
                Forms\Components\RichEditor::make('shortDescription')
                    ->label('Краткое описание')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                        'strike',
                    ]),
                Forms\Components\RichEditor::make('description')
                    ->label('Описание')
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
                    ->label('Название'),
                Tables\Columns\TextColumn::make('priceFrom')
                    ->label('Цена от'),
                Tables\Columns\TextColumn::make('time')
                    ->label('Сроки'),
//                Tables\Columns\TextColumn::make('description')
//                    ->label('Описание')
//                    ->html()
//                    ->wrap()
//                    ->words(30),
                Tables\Columns\IconColumn::make('isHighlighted')
                    ->label('Выделен')
                    ->boolean(),
            ])->defaultSort('sort', 'asc')
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
                    ->beforeReplicaSaved(function (Pricing $replica) {
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPricings::route('/'),
            'create' => Pages\CreatePricing::route('/create'),
            'edit' => Pages\EditPricing::route('/{record}/edit'),
        ];
    }
}
