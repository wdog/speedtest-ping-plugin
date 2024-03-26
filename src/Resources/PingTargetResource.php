<?php

namespace Wdog\Ping\Resources;

use App\Rules\Cron;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Wdog\Ping\Models\PingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\CreatePingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\EditPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\ListPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\ViewPingTarget;
use Wdog\Ping\Resources\PingTargetResource\RelationManagers\PingResultsRelationManager;

class PingTargetResource extends Resource
{
    protected static ?string $model = PingTarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ping';

    protected static ?string $navigationLabel = 'Targets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('PingTarget')->schema([
                    TextInput::make('target_name')
                        ->required()
                        ->dehydrateStateUsing(fn ($state) => Str::upper($state)),

                    TextInput::make('target_ip')
                        ->ip()
                        ->required(),

                    TextInput::make('target_schedule')
                        ->rules([new Cron()])
                        ->helperText('Leave empty to disable scheduled tests.')
                        ->hint(new HtmlString('&#x1f517;<a href="https://crontab.cronhub.io/" target="_blank" rel="nofollow">Cron Generator</a>'))
                        ->nullable(),

                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->recordAction(ViewPingTarget::class)
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('target_ip'),
                TextColumn::make('target_name'),
                TextColumn::make('target_schedule'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            PingResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPingTarget::route('/'),
            'create' => CreatePingTarget::route('/create'),
            'view' => ViewPingTarget::route('/{record}'),
            'edit' => EditPingTarget::route('/{record}/edit'),
        ];
    }
}
