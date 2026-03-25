<?php

namespace App\Filament\Resources;

use App\Models\JournalEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JournalEntryResource extends Resource
{
    protected static ?string $model = JournalEntry::class;
    // protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'erp.nav.accounting';
    protected static ?int $navigationSort = 3;

    public static function getLabel(): string
    {
        return __('erp.journal_entry');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.journal_entries');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.entry_details'))->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('reference')
                            ->label(__('erp.reference'))
                            ->default(fn() => JournalEntry::generateNumber())
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Select::make('journal_id')
                            ->label(__('erp.journal'))
                            ->relationship('journal', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label(__('erp.date'))
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label(__('erp.status'))
                            ->options([
                                'draft' => __('erp.draft'),
                                'posted' => __('erp.posted'),
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
                    Forms\Components\Textarea::make('description')
                        ->label(__('erp.description'))
                        ->rows(2),
                ]),

                Forms\Components\Section::make(__('erp.journal_entry_lines'))->schema([
                    Forms\Components\Repeater::make('lines')
                        ->relationship()
                        ->schema([
                            Forms\Components\Grid::make(4)->schema([
                                Forms\Components\Select::make('account_id')
                                    ->label(__('erp.account'))
                                    ->relationship('account', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('debit')
                                    ->label(__('erp.debit'))
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                Forms\Components\TextInput::make('credit')
                                    ->label(__('erp.credit'))
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ]),
                            Forms\Components\TextInput::make('description')
                                ->label(__('erp.description')),
                        ])
                        ->defaultItems(2)
                        ->columns(1),
                ]),
            ])->columnSpan(['lg' => fn(?JournalEntry $record) => $record === null ? 3 : 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make(__('erp.summary'))->schema([
                    Forms\Components\TextInput::make('total_debit')
                        ->label(__('erp.total_debit'))
                        ->numeric()
                        ->default(0)
                        ->readOnly(),
                    Forms\Components\TextInput::make('total_credit')
                        ->label(__('erp.total_credit'))
                        ->numeric()
                        ->default(0)
                        ->readOnly(),
                ]),
            ])->columnSpan(['lg' => 1])->hidden(fn(?JournalEntry $record) => $record === null),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label(__('erp.reference'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('erp.date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('journal.name')
                    ->label(__('erp.journal'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_debit')
                    ->label(__('erp.total_debit'))
                    ->money(fn($record) => $record->currency ?? 'USD'),
                Tables\Columns\TextColumn::make('total_credit')
                    ->label(__('erp.total_credit'))
                    ->money(fn($record) => $record->currency ?? 'USD'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'info' => 'draft',
                        'success' => 'posted',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => __('erp.draft'),
                        'posted' => __('erp.posted'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\JournalEntryResource\Pages\ListJournalEntries::route('/'),
            'create' => \App\Filament\Resources\JournalEntryResource\Pages\CreateJournalEntry::route('/create'),
            'edit' => \App\Filament\Resources\JournalEntryResource\Pages\EditJournalEntry::route('/{record}/edit'),
        ];
    }
}
