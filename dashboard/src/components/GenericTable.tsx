import * as React from "react"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

type Accessor<T> = keyof T | ((row: T) => React.ReactNode)

export type ColumnDef<T> = {
  label: string
  name: Accessor<T>
  className?: (row: T) => string
}

type GenericTableProps<T> = {
  columns: ColumnDef<T>[]
  data: T[]
}

export function GenericTable<T>({ columns, data }: GenericTableProps<T>) {
  const resolve = React.useCallback((row: T, name: Accessor<T>) => {
    if (typeof name === "function") return name(row)
    return row[name] as React.ReactNode
  }, [])

  return (
    <Table>
      <TableHeader>
        <TableRow>
          {columns.map((col, colIndex) => (
            <TableHead key={colIndex}>{col.label}</TableHead>
          ))}
        </TableRow>
      </TableHeader>

      <TableBody>
        {data.length === 0 ? (
          <TableRow>
            <TableCell
              colSpan={columns.length}
              className="text-center text-muted-foreground"
            >
              Nessun dato
            </TableCell>
          </TableRow>
        ) : (
          data.map((row, rowIndex) => (
            <TableRow key={rowIndex}>
              {columns.map((col, colIndex) => (
                <TableCell
                  key={colIndex}
                  className={col.className ? col.className(row) : undefined}
                >
                  {resolve(row, col.name)}
                </TableCell>
              ))}
            </TableRow>
          ))
        )}
      </TableBody>
    </Table>
  )
}
