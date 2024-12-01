<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvantageResource\Pages;
use App\Filament\Resources\AdvantageResource\RelationManagers;
use App\Models\Advantage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvantageResource extends Resource
{
    protected static ?string $model = Advantage::class;

    protected static ?string $navigationGroup = 'Главная страница';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Премущества';
    protected static ?string $modelLabel = 'Премущества';
    protected static ?string $pluralLabel = 'Премущества';
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

                Forms\Components\Section::make('')
                    ->description('Здесь подробные преимущества пишем. Они будут сменять друг друга.')
                    ->schema([
                        Forms\Components\Repeater::make('descriptions')
                            ->label('Преимущества - подробное описание')
                            ->simple(
                                Forms\Components\TextInput::make('description')
                                    ->required(),
                            )
                            ->createItemButtonLabel('Добавить преимущество'),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('')
                    ->description('Здесь коротко (1-2 слова) преимущества пишем. Они будут в каруселях крутиться.')
                    ->schema([
                        Forms\Components\Repeater::make('carousels')
                            ->label('Карусели с преимуществами')
                            ->schema([
                                Forms\Components\Repeater::make('carousel')
                                    ->label('Преимущество')
                                    ->simple(
                                        Forms\Components\TextInput::make('description')
                                            ->required(),
                                    )
                                    ->createItemButtonLabel('Добавить элемент карусели'),
                            ])
                            ->createItemButtonLabel('Добавить карусель'),
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

                Tables\Columns\TextColumn::make('descriptions')
                    ->label('Преимущества - подробное описание')
                    ->getStateUsing(function ($record) {
                        return implode('<br style="margin-bottom: 10px;">', $record->descriptions);
                    })
                    ->html()
                    ->wrap(),

                Tables\Columns\TextColumn::make('carousels')
                    ->label('Преимущества - карусели')

                    ->getStateUsing(function ($record) {
                        $out = array_map(function($item) {
                            return $item['carousel'];
                        }, $record->carousels);
                        return implode('<br style="margin-bottom: 20px;">', array_map(function ($group) {
                            return implode(', ', $group);
                        }, $out));
                    })
                    ->html()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('isActive')
                    ->label('Активность')
                    ->options([
                        1 => 'Да',
                        0 => 'Нет'
                    ])
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->button()
                    ->color('info')
                    ->modal(false)
                    ->beforeReplicaSaved(function (Advantage $replica) {
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
            'index' => Pages\ListAdvantages::route('/'),
            'create' => Pages\CreateAdvantage::route('/create'),
            'edit' => Pages\EditAdvantage::route('/{record}/edit'),
        ];
    }
}
