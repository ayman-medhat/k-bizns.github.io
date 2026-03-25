<?php

namespace App\Filament\Resources;

use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    // protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'erp.nav.crm';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.client');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.clients');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('erp.client_details'))->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')->label(__('erp.name'))->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->label(__('erp.email'))->email()->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('phone')->label(__('erp.phone'))->tel()->nullable()->maxLength(255),
                        Forms\Components\TextInput::make('website')->label(__('erp.website'))->url()->nullable()->maxLength(255),
                        Forms\Components\Select::make('status')->label(__('erp.status'))->options([
                            'active' => __('erp.active'),
                            'inactive' => __('erp.inactive'),
                        ])->default('active')->required(),
                        Forms\Components\Select::make('industry_id')->label(__('erp.industry'))->relationship('industry', 'name_en')->nullable()->searchable(),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('erp.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label(__('erp.email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('erp.phone'))->searchable(),
                Tables\Columns\TextColumn::make('status')->label(__('erp.status'))->badge(),
                Tables\Columns\TextColumn::make('industry.name_en')->label(__('erp.industry'))->searchable(),
            ])
            ->filters([])
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
            'index' => \App\Filament\Resources\ClientResource\Pages\ListClients::route('/'),
            'create' => \App\Filament\Resources\ClientResource\Pages\CreateClient::route('/create'),
            'edit' => \App\Filament\Resources\ClientResource\Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
