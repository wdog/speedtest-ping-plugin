<?php

namespace Wdog\Ping\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Wdog\Ping\Models\PingTarget;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Wdog\Ping\Resources\PingTargetResource\Pages\EditPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\ListPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\CreatePingTarget;


class PingTargetResource extends Resource
{
    protected static ?string $model = PingTarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('PingTarget')->schema([
                    TextInput::make('target_ip')->required(),
                    TextInput::make('target_name')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('target_ip'),
                TextColumn::make('target_name'),
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
            'index' => ListPingTarget::route('/'),
            'create' => CreatePingTarget::route('/create'),
            'edit' => EditPingTarget::route('/{record}/edit'),
        ];
    }
}
