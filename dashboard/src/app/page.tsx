import { Button } from "@/components/ui/button";

export default function Home() {
  return (
    <main className="container mx-auto px-4 py-8">
      <h1 className="text-4xl font-bold mb-6">Dashboard</h1>
      <div className="flex gap-4">
        <Button>Button Default</Button>
        <Button variant="secondary">Button Secondary</Button>
        <Button variant="outline">Button Outline</Button>
        <Button variant="destructive">Button Destructive</Button>
      </div>
    </main>
  );
}
