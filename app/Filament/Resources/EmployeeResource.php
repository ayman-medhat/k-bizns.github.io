<?php

namespace App\Filament\Resources;

use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    // protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'erp.nav.hr';
    protected static ?int $navigationSort = 1;

    public static function getLabel(): string
    {
        return __('erp.employee');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.employees');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.personal_info'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name_translations.en')
                        ->label(__('erp.name_en'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('name_translations.ar')
                        ->label(__('erp.name_ar'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('email')
                        ->label(__('erp.email'))
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label(__('erp.phone'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_id')
                        ->label(__('erp.national_id'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\DatePicker::make('birth_date')
                        ->label(__('erp.birth_date')),
                    Forms\Components\Select::make('gender')
                        ->label(__('erp.gender'))
                        ->options([
                            'male' => __('erp.male'),
                            'female' => __('erp.female'),
                        ]),
                ]),
            ]),
            Forms\Components\Section::make(__('erp.job_info'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('employee_number')
                        ->label(__('erp.employee_number')),
                    Forms\Components\TextInput::make('job_title')
                        ->label(__('erp.job_title')),
                    Forms\Components\TextInput::make('department')
                        ->label(__('erp.department')),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\DatePicker::make('hire_date')
                        ->label(__('erp.hire_date')),
                    Forms\Components\Select::make('status')
                        ->label(__('erp.status'))
                        ->options([
                            'active' => __('erp.active'),
                            'inactive' => __('erp.inactive'),
                            'terminated' => __('erp.terminated'),
                        ])
                        ->default('active')
                        ->required(),
                    Forms\Components\Select::make('user_id')
                        ->label(__('erp.linked_user'))
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload(),
                ]),
            ]),
            Forms\Components\Section::make(__('erp.payroll_settings'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('basic_salary')
                        ->label(__('erp.basic_salary'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\TextInput::make('currency')
                        ->label(__('erp.currency'))
                        ->default('USD'),
                    Forms\Components\TextInput::make('bank_account')
                        ->label(__('erp.bank_account')),
                ]),
            ]),
            Forms\Components\Section::make(__('erp.photo'))->schema([
                Forms\Components\FileUpload::make('photo')
                    ->label(__('erp.photo'))
                    ->image()
                    ->directory('employees'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=E&color=D2B48C&background=231414'),
                Tables\Columns\TextColumn::make('name_translations.en')
                    ->label(__('erp.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_number')
                    ->label(__('erp.employee_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label(__('erp.job_title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->label(__('erp.department')),
                Tables\Columns\TextColumn::make('basic_salary')
                    ->label(__('erp.basic_salary'))
                    ->money(fn($record) => $record->currency ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'terminated',
                        'warning' => 'inactive',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => __('erp.active'),
                        'inactive' => __('erp.inactive'),
                        'terminated' => __('erp.terminated'),
                    ]),
                Tables\Filters\SelectFilter::make('department')
                    ->options(fn() => Employee::distinct()->pluck('department', 'department')->toArray()),
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
            'index' => \App\Filament\Resources\EmployeeResource\Pages\ListEmployees::route('/'),
            'create' => \App\Filament\Resources\EmployeeResource\Pages\CreateEmployee::route('/create'),
            'edit' => \App\Filament\Resources\EmployeeResource\Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
