const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

io.on('connection', (socket) => {
    console.log('New user connected');

    socket.on('join', (room) => {
        socket.join(room);
        console.log(`User  joined room: ${room}`);
    });

    socket.on('signal', (data) => {
        io.to(data.room).emit('signal', {
            signal: data.signal,
            sender: socket.id,
        });
    });

    socket.on('disconnect', () => {
        console.log('User  disconnected');
    });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Signaling server running on port ${PORT}`);
});