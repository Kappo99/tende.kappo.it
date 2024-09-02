// src/wind/wind.service.ts
import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { WindSensor } from './wind.entity';

@Injectable()
export class WindService {
  constructor(
    @InjectRepository(WindSensor)
    private readonly windRepository: Repository<WindSensor>,
  ) {}

  async getWindData(dateGet?: string, minValue?: number, windLimit: number = 100) {
    let whereSQL = '1=1'; // condizione di default che è sempre vera

    // Gestione del filtro sulla data
    if (dateGet) {
      whereSQL += ` AND date LIKE :dateGet`;
    }

    // Gestione del filtro sul valore minimo
    if (minValue) {
      whereSQL += ` AND frequency >= :minValue`;
    }

    // Costruzione della query
    const queryBuilder = this.windRepository
      .createQueryBuilder('wind')
      .where(whereSQL, { dateGet: `${dateGet}%`, minValue })
      .orderBy('wind.date', 'DESC')
      .limit(windLimit);

    const windData = await queryBuilder.getMany();

    // Trasformazione dei dati in JSON
    return windData.map((wd) => ({
      id: wd.id,
      date: wd.date,
      frequency: wd.frequency,
    }));
  }
}
