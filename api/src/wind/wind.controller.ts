// src/wind/wind.controller.ts
import { Controller, Get, Query } from '@nestjs/common';
import { WindService } from './wind.service';

@Controller('wind')
export class WindController {
  constructor(private readonly windService: WindService) {}

  @Get()
  async getWindData(
    @Query('date') dateGet?: string, // Parametro opzionale per la data
    @Query('minValue') minValue?: number, // Parametro opzionale per il valore minimo
    @Query('rowsLimit') windLimit: number = 100, // Parametro opzionale per limitare il numero di righe
  ) {
    return this.windService.getWindData(dateGet, minValue, windLimit);
  }
}
