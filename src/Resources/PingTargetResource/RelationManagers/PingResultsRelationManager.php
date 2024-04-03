<?php

namespace Wdog\Ping\Resources\PingTargetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PingResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    protected $listeners = [
        'refreshPing' => '$refresh',
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ping'),
                Forms\Components\TextInput::make('data')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->recordTitleAttribute('created_at')
            ->columns([
                Tables\Columns\TextColumn::make('ping')->suffix(' ms'),
                Tables\Columns\TextColumn::make('data'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d H:i:s')->alignEnd(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
