<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsBlockResource\Pages;
use App\Filament\Resources\AboutUsBlockResource\RelationManagers;
use App\Models\AboutUsBlock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsBlockResource extends Resource
{
    protected static ?string $model = AboutUsBlock::class;
    protected static ?string $navigationGroup = 'Главная страница';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'О нас';
    protected static ?string $pluralLabel = 'Список блоков о нас';
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


                Forms\Components\TextInput::make('subtitle')
                    ->label('Подзаголовок')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('Заголовок')
                    ->required(),
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

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Подзаголовок'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->wrap(),
//                Tables\Columns\TextColumn::make('description')
//                    ->label('Описание')
//                    ->html()
//                    ->wrap()
//                    ->words(30),
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
                    ->beforeReplicaSaved(function (AboutUsBlock $replica) {
                        $replica->subtitle = 'КОПИЯ ' . $replica->subtitle;
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
            'index' => Pages\ListAboutUsBlocks::route('/'),
            'create' => Pages\CreateAboutUsBlock::route('/create'),
            'edit' => Pages\EditAboutUsBlock::route('/{record}/edit'),
        ];
    }
}
