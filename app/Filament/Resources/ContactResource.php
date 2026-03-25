<?php

namespace App\Filament\Resources;

use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    // // protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'erp.nav.crm';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.contact');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.contacts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('erp.contact_details'))->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('first_name_en')->label(__('erp.first_name_en'))->required()->maxLength(255),
                        Forms\Components\TextInput::make('last_name_en')->label(__('erp.last_name_en'))->maxLength(255),
                        Forms\Components\TextInput::make('first_name_ar')->label(__('erp.first_name_ar'))->maxLength(255),
                        Forms\Components\TextInput::make('last_name_ar')->label(__('erp.last_name_ar'))->maxLength(255),
                        Forms\Components\TextInput::make('email')->label(__('erp.email'))->email()->maxLength(255),
                        Forms\Components\TextInput::make('phone')->label(__('erp.phone'))->tel()->maxLength(255),
                        Forms\Components\Select::make('client_id')->label(__('erp.client'))->relationship('client', 'name')->searchable(),
                        Forms\Components\TextInput::make('national_id')->label(__('erp.national_id'))->maxLength(20),
                        Forms\Components\DatePicker::make('birthdate')->label(__('erp.birthdate')),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name_en')->label(__('erp.first_name_en'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name_en')->label(__('erp.last_name_en'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label(__('erp.email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('erp.phone'))->searchable(),
                Tables\Columns\TextColumn::make('client.name')->label(__('erp.client'))->searchable(),
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
            'index' => \App\Filament\Resources\ContactResource\Pages\ListContacts::route('/'),
            'create' => \App\Filament\Resources\ContactResource\Pages\CreateContact::route('/create'),
            'edit' => \App\Filament\Resources\ContactResource\Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
