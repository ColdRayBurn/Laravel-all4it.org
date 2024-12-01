<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Блог';
    protected static ?string $modelLabel = 'пост';
    protected static ?string $pluralLabel = 'Список постов';
    protected static ?string $navigationIcon = 'heroicon-o-pencil';

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
                Forms\Components\FileUpload::make('image')
                    ->label('Картинка')
                    //->image()
                    ->required()
                    ->disk('public'),
                Forms\Components\RichEditor::make('content')
                    ->label('Контент')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                        'strike',
                    ]),
                Forms\Components\DateTimePicker::make('publishDatetime')
                    ->label('Дата и время публикации')
                    ->required()
                    ->format('Y-m-d H:i')
                    ->native(false)
                    ->seconds(false),
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
                Tables\Columns\ImageColumn::make('image')
                    ->label('Картинка')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('publishDatetime')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
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
                    ->beforeReplicaSaved(function (Blog $replica) {
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
