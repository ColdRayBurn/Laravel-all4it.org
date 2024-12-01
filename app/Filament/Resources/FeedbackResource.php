<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Обращения';
    protected static ?string $modelLabel = 'обращение';
    protected static ?string $pluralLabel = 'Список обращений';

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->recordUrl(null)
            ->columns([
                Tables\Columns\ToggleColumn::make('isResolved')
                    ->label('Разрешено')
                    ->sortable()
                    ->action(function ($record, $state) {
                        $record->update(['isResolved' => $state]);
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('email')
                    ->label('email')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-arrow-small-right')
                    ->iconPosition('after')
                    ->formatStateUsing(fn($state) => "<a href='mailto:$state'>$state</a>")
                    ->html(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->label('Телефон')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('companyName')
                    ->label('Компания')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Текст')
                    ->searchable()
                    ->words(50)
                    ->html()
                    ->formatStateUsing(fn($state) => nl2br(e($state))) // Преобразует \n в <br>
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->wrap()
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Обращений нет')
            ->filters([
                SelectFilter::make('isResolved')
                    ->label('Разрешено')
                    ->options([
                        1 => 'Да',
                        0 => 'Нет'
                    ])
                    ->default(0),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->modalHeading('Просмотр обращения')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Имя')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('email')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phoneNumber')
                            ->label('Телефон')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('companyName')
                            ->label('Компания')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('comment')
                            ->label('Текст')
                            ->required()
                            ->formatStateUsing(fn($state) => nl2br(e($state))),
                    ])
                    ->extraModalFooterActions([
                        Tables\Actions\Action::make('sendEmail')
                            ->label('Отправить Email')
                            ->color('primary')
                            ->url(fn($record) => "mailto:{$record['email']}"),
                    ]),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => Pages\ListFeedback::route('/'),
//            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }


    // Отключает кнопку "Создать"
    public static function canCreate(): bool
    {
        return false;
    }
}
