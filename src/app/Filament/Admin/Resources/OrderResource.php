<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1),

                TextInput::make('team_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('color_choice')
                    ->required()
                    ->maxLength(255),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->nullable(),

                FileUpload::make('logo_file')
                    ->label('Upload Logo')
                    ->directory('logos')
                    ->image()
                    ->maxSize(2048)
                    ->nullable(),
                Forms\Components\FileUpload::make('design_file')
                    ->label('Upload Desain Jersey')
                    ->directory('designs')
                    ->image()
                    ->maxSize(4096)
                    ->nullable(),

                TextInput::make('total_price')
                    ->label('Total Price (otomatis)')
                    ->disabled()
                    ->dehydrated(false), // agar tidak ikut terkirim saat submit
                  
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),

                Tables\Columns\TextColumn::make('team_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('color_choice'),

                Tables\Columns\ImageColumn::make('logo_file')
                    ->label('Logo'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'completed' => 'primary',
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('idr', true)
                    ->label('Total Price'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
