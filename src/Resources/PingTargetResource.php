<?php

namespace Wdog\Ping\Resources;


use App\Rules\Cron;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Wdog\Ping\Models\PingTarget;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Wdog\Ping\Resources\PingTargetResource\Pages\EditPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\ListPingTarget;
use Wdog\Ping\Resources\PingTargetResource\Pages\CreatePingTarget;


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
                        ->nullable()

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
