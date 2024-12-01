<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GlobalInfoResource\Pages;
use App\Filament\Resources\GlobalInfoResource\RelationManagers;
use App\Models\GlobalInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GlobalInfoResource extends Resource
{
    protected static ?string $model = GlobalInfo::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Глобальная информация';
    protected static ?string $modelLabel = 'Глобальная информация';
    protected static ?string $pluralLabel = 'Глобальная информация';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

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

                Forms\Components\Section::make('Страница')
                    ->schema([
                        Forms\Components\TextInput::make('page_title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\RichEditor::make('page_description')
                            ->label('Описание')
                            ->required()
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                                'strike',
                            ]),
                        Forms\Components\FileUpload::make('logotype')
                            ->label('Логотип')
                            //->image()
                            ->required()
                            ->disk('public'),  // диск для хранения
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Контакты')
                    ->description('')
                    ->schema([
                        Forms\Components\Repeater::make('contacts')
                        ->label('Контакты')
                        ->hiddenLabel()
                        ->schema([
                            Forms\Components\TextInput::make('contact_type')
                            ->label('Тип контакта')
                            ->required(),

                            Forms\Components\TextInput::make('value')
                            ->label('Контакт')
                            ->required(),
                        ])
                            ->columns(1)
                            ->minItems(1)
                            ->maxItems(10)
                            ->defaultItems(2),

                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Футер')
                    ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('footer_title')
                            ->label('Заголовок')
                            ->required(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('Для отображения выбирается первый активный элемент (с мин. значением сортировки).')
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

                Tables\Columns\TextColumn::make('page_title')
                    ->label('Заголовок')
                    ->words(10),
                Tables\Columns\TextColumn::make('page_description')
                    ->label('Описание')
                    ->html()
                    ->wrap()
                    ->words(20),
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
                    ])
                    ->default(1),
                SelectFilter::make('language_id')
                    ->label('Язык')
                    ->options(\App\Models\Language::pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->button()
                    ->color('info')
                    ->modal(false)
                    ->beforeReplicaSaved(function (GlobalInfo $replica) {
                        $replica->page_title = 'КОПИЯ ' . $replica->page_title;
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
            'index' => Pages\ListGlobalInfos::route('/'),
            'create' => Pages\CreateGlobalInfo::route('/create'),
            'edit' => Pages\EditGlobalInfo::route('/{record}/edit'),
        ];
    }
}
