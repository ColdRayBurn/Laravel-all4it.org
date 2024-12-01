<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioItemResource\Pages;
use App\Filament\Resources\PortfolioItemResource\RelationManagers;
use App\Models\PortfolioItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioItemResource extends Resource
{
    protected static ?string $model = PortfolioItem::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Портфолио';
    protected static ?string $modelLabel = 'проект';
    protected static ?string $pluralLabel = 'Список проектов';
    protected static ?string $navigationIcon = 'heroicon-m-window';

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


                Forms\Components\Section::make('')
                    ->description('Это в списке проектов выводится')
                    ->schema([
                        Forms\Components\FileUpload::make('logotype')
                            ->label('Логотип')
                            ->image()
                            ->required()
                            ->disk('public'),  // диск для хранения
                        Forms\Components\Textarea::make('shortDescription')
                            ->label('Короткое описание')
                            ->required(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('')
                    ->description('Это в деталке проекта выводится')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\Textarea::make('secondShortDescription')
                            ->label('Второе короткое описание')
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Описание')
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                        Forms\Components\TextInput::make('url')
                            ->label('Сайт')
                            ->url()
                            ->required(),
                        Forms\Components\DatePicker::make('developmentDate')
                            ->label('Дата')
                            ->required()
                            ->format('Y-m-d')
                            ->native(false),
                        Forms\Components\FileUpload::make('gallery')
                            ->label('Картинки')
                            //->image()
                            ->required()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3'
                            ])
                            ->disk('public'),  // диск для хранения
                    ])
                    ->collapsible(),


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
                    ->label('Заголовок')
                    ->words(10),
//                Tables\Columns\TextColumn::make('description')
//                    ->label('Описание')
//                    ->html()
//                    ->wrap()
//                    ->words(20),
                Tables\Columns\ImageColumn::make('logotype')
                    ->label('Логотип')
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
                    ->beforeReplicaSaved(function (PortfolioItem $replica) {
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
            'index' => Pages\ListPortfolioItems::route('/'),
            'create' => Pages\CreatePortfolioItem::route('/create'),
            'edit' => Pages\EditPortfolioItem::route('/{record}/edit'),
        ];
    }
}
