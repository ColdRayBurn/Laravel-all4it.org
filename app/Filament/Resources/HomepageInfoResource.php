<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageInfoResource\Pages;
use App\Filament\Resources\HomepageInfoResource\RelationManagers;
use App\Models\HomepageInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomepageInfoResource extends Resource
{
    protected static ?string $model = HomepageInfo::class;
    protected static ?string $navigationGroup = 'Главная страница';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Баннер и текст страницы';
    protected static ?string $modelLabel = 'баннер';
    protected static ?string $pluralLabel = 'Список баннеров';
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

                Forms\Components\Section::make('Главный баннер')
                    ->description('картинки желательно 16 к 9.')
                    ->schema([
                        Forms\Components\RichEditor::make('title')
                            ->label('Заголовок')
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
                        Forms\Components\FileUpload::make('images')
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

                Forms\Components\Section::make('Преимущества битрикса')
                    ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('advantages_title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\RichEditor::make('advantages_description')
                            ->label('Описание')
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('О нас')
                    ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('aboutus_title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\RichEditor::make('aboutus_description')
                            ->label('Описание')
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Прейскурант')
                    ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('pricelist_title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\RichEditor::make('pricelist_description')
                            ->label('Описание')
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Наши клиенты')
                    ->description('')
                    ->schema([
//                        Forms\Components\TextInput::make('customers_title')
//                            ->label('Заголовок')
//                            //->required()
//                        ,
                        Forms\Components\RichEditor::make('customers_description')
                            ->label('Описание')
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                    ])
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            //->heading('Список баннеров')
            ->description('Для отображения выбирается первый активный баннер (с мин. значением сортировки).')
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
                    ->html()
                    ->wrap()
                    ->words(10),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->html()
                    ->wrap()
                    ->words(20),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Картинки')
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
                    ->beforeReplicaSaved(function (HomepageInfo $replica) {
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
            'index' => Pages\ListHomepageInfos::route('/'),
            'create' => Pages\CreateHomepageInfo::route('/create'),
            'edit' => Pages\EditHomepageInfo::route('/{record}/edit'),
        ];
    }
}
