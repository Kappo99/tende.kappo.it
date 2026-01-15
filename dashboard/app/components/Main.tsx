
export default function Main() {
    return (
        <main>
        <aside>
          <div className="sidebar-item">Menu 1</div>
          <div className="sidebar-item">Menu 2</div>
          <div className="sidebar-item">Menu 3</div>
          <div className="sidebar-item">Menu 4</div>
          <div className="sidebar-item">Menu 5</div>
        </aside>

        <section id="content">
          <div className="hero">
            <div className="hero-text">HERO SECTION</div>
          </div>

          <div className="cards-container">
            <div className="card">
              <div className="card-title">Card 1</div>
              <div className="card-content">Content</div>
            </div>
            <div className="card">
              <div className="card-title">Card 2</div>
              <div className="card-content">Content</div>
            </div>
            <div className="card">
              <div className="card-title">Card 3</div>
              <div className="card-content">Content</div>
            </div>
          </div>

          <div className="bottom-section">
            <div className="left-box">
              Large Box
            </div>
            <div className="right-column">
              <div className="small-box">Small Box 1</div>
              <div className="small-box">Small Box 2</div>
            </div>
          </div>
        </section>
      </main>
    );
}