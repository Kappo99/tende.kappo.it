// src/wind/wind.entity.ts
import { Entity, PrimaryGeneratedColumn, Column } from "typeorm"

@Entity('smart-home_wind-sensor')
export class WindSensor {
	@PrimaryGeneratedColumn()
	id: number;

	@Column()
	date: string;

	@Column()
	frequency: number;
}
